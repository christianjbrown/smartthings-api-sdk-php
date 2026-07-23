# CLAUDE.md

Guidance for working in this repository. Match the existing conventions exactly — this codebase is
small, uniform, and highly opinionated, so new code should be indistinguishable from what's here.

## What this is

A strongly-typed, **read-only** PHP 8.5+ client for the [SmartThings API](https://developer.smartthings.com/).
It lists devices and locations, reads a device's status, and reads rooms, returning typed model
objects instead of raw arrays. The primary entry point is the `SmartThings` facade (`src/SmartThings.php`),
which wires the clients and their transformer chains through a Symfony `ContainerBuilder` DI container.
Hand-wiring the same chains without the container is still fully supported (see the "Wiring the clients"
section of `README.md`).

## Commands

Binaries install into `bin/` (Composer `bin-dir`), not `vendor/bin/`. Both `bin/` and `vendor/` are
gitignored and Composer-installed, so run `composer install` first.

| Task | Command |
| --- | --- |
| Run tests + coverage (opens HTML report) | `composer test` |
| Run tests, no coverage | `php -d memory_limit=-1 ./bin/phpunit --no-coverage` |
| Run one test | `php -d memory_limit=-1 ./bin/phpunit --filter DeviceTransformerTest` |
| Check code style | `composer check-style` |
| Auto-fix code style | `composer fix-style` |
| Check / fix style on git diff only | `composer check-style-diff` / `composer fix-style-diff` |

After adding autoloadable files, run `composer dump-autoload` if the class isn't found.

Style tooling comes from the `christianjbrown/php-code-quality-scripts` dev dependency: `check-style`
lints with **PHP_CodeSniffer 4** using the **`ChristianBrown` standard** (slevomat sniffs plus
PSR/PEAR/Squiz/Generic), and **php-cs-fixer** (`@PhpCsFixer`/`@Symfony`) handles formatting; the
`bin/php-cs*` scripts are thin wrappers over it.
Static analysis is **PHPStan at `level: max`** (`phpstan.neon.dist`, run with `composer stan` /
`./bin/phpstan analyse`), and there is a **GitHub Actions CI workflow** (`.github/workflows/ci.yml`)
that runs style, PHPStan, and the PHPUnit suite with coverage on every push/PR. Always run
`composer fix-style` first (php-cs-fixer auto-fixes what it can), then `composer check-style` to
surface any remaining violations that must be fixed by hand, then `composer stan` and `composer test`
before finishing.

## Architecture

Three layers under `src/`, mirrored 1:1 under `tests/`, plus the top-level `SmartThings` facade. PSR-4:
`ChristianBrown\SmartThings\` → `src/`, `ChristianBrown\SmartThings\Tests\` → `tests/`.

- **`SmartThings`** (`src/SmartThings.php`) — the facade/entry point. Constructed with just a
  `string $apiToken`, it builds a Symfony `ContainerBuilder`, registers every transformer and client
  as a service (ids on `SmartThingsInterface` as `SERVICE_*` constants), and exposes `getDeviceApi()`,
  `getDeviceStatusApi()`, `getLocationApi()`, and `getLocationRoomApi()`.
- **`Api/`** — HTTP clients (`DeviceApi`, `DeviceStatusApi`, `LocationApi`, `LocationRoomApi`). Each is
  constructed with a `JsonApiRequestSenderInterface` (from `christianjbrown/php-api-client-lib` — no
  Guzzle/PSR-18 used directly), its transformer(s), and a `string $apiToken`. They send an
  `Authorization: Bearer <token>` header, defensively validate the response shape, delegate to the
  transformer, and return a typed model. List endpoints validate the `items`/`components` wrapper key;
  single-object endpoints (`LocationApi::getOneById`, `LocationRoomApi`'s `getOne`) guard against an
  empty response before delegating. Clients cache by id (`LocationRoomApi` caches by roomId).
  **Pagination**: `DeviceHistoryApi::getMultiple` is the one paged client — an isolated `fetchAllPages`
  loop follows the response's `_links.next.href` chain, aggregating every page's `items` (via
  `array_merge`) until the API drops the next link or a caller-supplied `$maxPages` cap is hit; a
  stateless `extractNextHref` guards each level of the `_links`/`next`/`href` walk, and an **empty
  `items` array is a valid, non-error result** there (so it uses `isset`/`is_array`, not `empty()`).
  Note: those guards are written as **separate sequential `if`s, never a compound `if (A || B)`** —
  xdebug path coverage explodes combinatorially on `||`/`&&`, so keeping one condition per `if` is
  what lets the paged client still hit 100% path coverage.
- **`Transformer/`** — turn raw decoded-JSON arrays into `Model` objects. Nested transformers are
  constructor-injected and composed into a chain (e.g. `DevicesTransformer` → `DeviceTransformer` →
  `DeviceComponentsTransformer` → … → leaf). `DeviceStatusTransformer` supports the
  `temperatureMeasurement`, `relativeHumidityMeasurement` and `battery` capabilities via a
  `capabilityKey => applier` map built in its constructor: `transform()` dispatches over the map with
  `array_map` (no `foreach`), so a new capability is added by registering one map entry — the dispatch
  logic itself stays closed for modification.
- **`Model/`** — plain, mutable typed DTOs with getters and fluent setters.
- **`Exception/`** — `final` exception classes + matching interfaces: `UnexpectedResponseException`
  (extends `RuntimeException`, thrown by clients and transformers for malformed responses) and
  `MissingInputException` (extends `InvalidArgumentException`, thrown for bad caller input).

## Conventions (follow all of these)

- `declare(strict_types=1);` on every file, immediately after `<?php`.
- **Every concrete class is `final` and implements a matching `...Interface`** in the same namespace
  (`DeviceApi`/`DeviceApiInterface`, `DeviceTransformer`/`DeviceTransformerInterface`). No abstract
  base classes — composition over inheritance.
- **Constants live on the interface, not the class**: URLs, JSON keys (`KEY_*`), and sprintf message
  templates (`*_SPRINTF`). Parameterized URLs use `API_URL_SPRINTF`. E.g.
  `DeviceApiInterface::API_URL`, `DeviceTransformerInterface::KEY_DEVICE_ID`, `UNEXPECTED_STRING_SPRINTF`.
- **No constructor property promotion** — declare typed `private` properties and assign them in the
  constructor body. Class members (properties and methods) are ordered **alphabetically**.
- Import functions with `use function is_array;` etc. (after class imports, blank line between), and
  call them unqualified.
- **Models**: required fields are constructor args; optionals default (`?string $label = null`,
  `array $components = []`). Getters `getX()`; fluent setters `setX($value)` (param literally
  `$value`) that `return $this` typed as the **interface** (`setLabel(?string $value): DeviceInterface`).
  No enums, no `readonly`, no immutability.
- **Transformers**: one `transform(array $data): ...` method. Object transformers return a model
  interface; collection transformers (plural names) return `array`, looping with an indexed
  `for` over `array_values($data)` and delegating to the singular transformer. Guard required fields
  with a presence check then a type check (`is_string`/`is_array`/`is_float`/`is_int`), each throwing
  `UnexpectedResponseException(sprintf(self::..._SPRINTF, self::KEY_...))`. Use `empty()` for the presence
  check on string/array fields, but **`isset()` for numeric fields** so a legitimate `0`/`0.0` isn't
  rejected as "not set" (see the temperature/humidity leaf transformers). Optional fields are **silently
  skipped** when absent or wrong-typed. Type coercion (e.g. `strtotime()` for timestamps) happens here.
- **Exceptions live in `src/Exception/`**, each a `final` class + matching `...Interface`. Every exception
  interface extends the library-wide `ExceptionInterface` (which extends `Throwable`), so a single
  `catch (ExceptionInterface)` covers everything this library throws while dependency exceptions bubble up.
  Use `UnexpectedResponseException` (extends
  `RuntimeException`) whenever the API returns a body we can't parse — every client response-shape guard
  and every transformer required-field guard throws it. Use `MissingInputException` (extends
  `InvalidArgumentException`) for bad caller input, e.g. a `DeviceInterface` with no location/room id in
  `LocationRoomApi`. Message text stays in `KEY_*`/`*_SPRINTF`/message constants on the relevant
  `Api`/`Transformer` interface — the exception classes carry no constants. Request errors still surface
  as `RequestExceptionInterface` from the api-client lib. Public methods that can throw carry `@throws`
  docblocks naming the concrete exception(s).
- **A method that does not use `$this` must be `static`** (called via `self::`) — a stateless helper
  is static. Enforced for private methods by the shared `RequireStaticPrivateMethodRule` PHPStan rule
  (via `php-code-quality-scripts`' `config/phpstan.neon`); interface/override methods stay instance.

## Testing

The `phpunit.xml` config is strict (`requireCoverageMetadata`, `beStrictAboutCoverageMetadata`,
`failOnRisky`, `failOnWarning`, path coverage). Note: `<source>` sets `ignoreIndirectDeprecations="true"`
and no longer sets `restrictDeprecations` — this is a deliberate concession so Symfony DI's internal
deprecation notices don't fail the suite; `restrictNotices` and `restrictWarnings` remain on. With that
in mind:

- **Coverage must stay at 100%** — line, path, method/function, and branch. Every code path,
  including each defensive guard and every optional-field branch in the transformers, must be
  exercised (see the exhaustive data provider in `tests/Transformer/DeviceTransformerTest.php`).
  **Always run `composer test` and check the coverage report** before finishing — it prints a text
  summary to stdout and writes HTML to `.phpunit.cache/code-coverage-html/index.html`. `phpunit.xml`
  sets `includeUncoveredFiles` and `pathCoverage`, so any untested file, path, or branch shows up
  there. New code without full coverage is not done.
- **Every test class needs a `#[CoversClass(...)]` attribute** (may list more than one) or the run
  fails. Use PHPUnit 12 **attributes, not annotations**: `#[CoversClass]`, `#[DataProvider]`,
  `#[TestWith]`.
- Tests mirror `src/` 1:1 under `tests/<Layer>/`, one `final class XTest extends TestCase` per class,
  methods named `test<Method><Scenario>` (e.g. `testTransform`, `testGetUnexpectedResponse`).
- Mock every collaborator with `$this->createMock(SomeInterface::class)`; assert statically
  (`self::assertSame`). Reference the **same interface constants** production code uses — for both
  data keys and expected exception messages — so no strings are hardcoded. See
  `tests/Transformer/DeviceTransformerTest.php` for the data-provider style that exhaustively covers
  optional-field combinations.

## Adding a feature (e.g. a new capability)

1. Add the `Model` DTO + its interface (constants, if any, on the interface).
2. Add the `Transformer` + its interface, with `KEY_*` and `*_SPRINTF` constants on the interface.
3. Wire the new transformer into its parent transformer's constructor chain. For a new device-status
   capability, inject its transformer into `DeviceStatusTransformer` and register a
   `self::KEY_… => applier` entry in the `capabilityAppliers` map — `transform()` needs no change.
4. If it's a new endpoint, extend/add the `Api` client and its interface (`API_URL*` constant).
5. Add a matching `#[CoversClass]` test under `tests/<Layer>/`.
6. Run `composer fix-style`, then `composer check-style` to catch anything left to fix by hand, then
   `composer test` and **confirm the coverage report is 100%** on
   lines, paths, methods, and branches (cover each defensive guard and every optional-field
   combination — use a data provider like the transformer tests do).
