# Changelog

All notable changes to this package are recorded here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- `SmartThingsFactory` (behind `SmartThingsFactoryInterface`) builds the facade: `create($token)` for
  production, `createForHost($token, $apiHost)` for another host, and `createContainer($token, $apiHost)`
  for the container itself.

### Changed

- **Breaking:** the `SmartThings` constructor takes a PSR `ContainerInterface` and builds nothing. Replace
  `new SmartThings($token)` with `(new SmartThingsFactory())->create($token)`, and
  `new SmartThings($token, $apiHost)` with `(new SmartThingsFactory())->createForHost($token, $apiHost)`.
  See "Upgrading to 3.0" in the README.
- **Breaking:** `ContainerFactory` takes the list of `ServiceRegistrarInterface` instances to run, in order,
  instead of a token and an API host. `SmartThingsFactory::createContainer()` builds the default container.

### Removed

- **Breaking:** `ShapeRegistrar`, which registered about 400 shared transformers and serializers in one
  method. Eighteen per-domain `*ShapeRegistrar` classes (for example `DeviceShapeRegistrar`,
  `DeviceConfigurationShapeRegistrar` and `CapabilityPresentationShapeRegistrar`) register the same services,
  and `SmartThingsFactory` runs them in its place. Code that ran `ShapeRegistrar` on its own container runs
  those instead.

## [2.0.1] - 2026-09-30

The 2.0 release. It covers every operation in the SmartThings public API and reads every response field the
API documents. Code that uses the `SmartThings` facade needs no changes.

### Changed

- **Breaking:** the fallbacks that built a default serializer or transformer for a collaborator you left
  out are gone. Every collaborator of an `*Api` class, and of the transformers and serializers that take
  collaborators, is now a required constructor argument typed on its interface. Code that constructs `*Api`
  classes by hand has to pass them, including the `RequestUrlBuilderInterface` that the clients with query
  parameters now take. See "Upgrading to 2.0" in the README.
- The list calls that SmartThings pages (devices, locations, rooms, rules, installed apps, capabilities,
  drivers, channels, profiles, preferences, schedules, subscriptions, apps and scenes) now follow the
  `_links.next` links, up to 100 pages, and return every item. They used to return only the first page.
- Cached responses are keyed by the full URL, organization and language, so a filtered call is never
  answered from an unfiltered one.
- Response models expose many more of the documented fields, including the detail blocks and child devices on
  devices, and further fields on locations, rooms, modes, schedules, installed apps, apps, schema apps,
  subscriptions, scenes, Edge channels, drivers and hubs. Fields that a response may omit are nullable.

### Added

- Write operations across the API: device install, update, delete and events; locations (create, update,
  patch, delete); rules (create, update, delete, delete all); device profiles; device preference definitions;
  installed apps, subscriptions and schedules; apps, including their settings and OAuth configuration;
  capabilities, capability presentations and localizations, and device preference localizations; Edge
  channels, drivers and hubs; ST Schema connectors; and location services.
- Text to speech (voices, conversion and playing text on a device), schema app invitations, Edge driver
  package upload, and `getAlertLink` for the coordinate service's weather alert link.
- Typed models where the earlier calls took raw arrays or dropped the data: the Rule action tree and action
  sequence, device profile components and preferences, capability presentation sections, device
  configurations and device presentations, installed app configuration entries, and the per-action results of
  a rule execution.
- `getReportById`, `getComponentReport` and `getCapabilityReport` on the device status client, which return
  every component, capability and attribute a device reports along with its health.
- The optional query parameters the API defines on list and get calls, including query objects for devices,
  installed apps, apps, rules, locations and device preferences. Lists are sent as repeated parameters.
- The `X-ST-Organization` and `Accept-Language` headers where the API accepts them.
- `ApiError` and `ErrorResponse`, with `getErrorResponseTransformer()` on the facade, so the decoded body of a
  failed request can be read as typed data.
- `getSchemaAppOwnerApi()`, which returns the organization and user app lists with their `organizationIds` and
  `userId`.

### Fixed

- Responses no longer fail to parse when a field the API marks as required is missing or has an unexpected
  type. SmartThings omits some of these fields, for example `driverId` on some hub devices. Every field and
  block that 1.2.0 did not read now comes back as `null`, or as an empty list, instead of throwing. Fields
  that 1.2.0 already threw for still do.

## [1.2.0] - 2026-09-28

### Added

- Write operations: run one or more capability commands on a device (`executeCommands`), switch a
  location's current mode, execute a scene, and execute a rule.
- Create, update and delete for location rooms and modes.

## [1.0.0] - 2026-09-28

First stable release.

### Added

- `SmartThings`, an entry point for the SmartThings API that authenticates with a personal access token. The
  client was read-only at this release and returns typed model objects rather than raw arrays.
- Reads for devices, virtual devices, device status (temperature, humidity and battery), device health and
  device preferences, plus device preference definitions.
- Reads for locations, rooms, modes, scenes and rules.
- Reads for capabilities, device profiles, presentations and device configurations.
- Reads for apps, installed apps, subscriptions, schedules and ST Schema connectors.
- Reads for Edge hubs, channels and drivers, location services (weather and air quality) and organizations.
- Translation reads for capabilities, device profiles and device preference definitions.
- Device event history, paged across the API's `_links.next` chain with an optional page cap.
- An optional `ApiHostInterface` argument on `SmartThings` to point requests at another host.
- A single exception hierarchy, so callers do not depend on the underlying HTTP client.

[Unreleased]: https://github.com/christianjbrown/smartthings-api-sdk-php/compare/v2.0.1...HEAD
[2.0.1]: https://github.com/christianjbrown/smartthings-api-sdk-php/compare/v1.2.0...v2.0.1
[1.2.0]: https://github.com/christianjbrown/smartthings-api-sdk-php/compare/v1.0.0...v1.2.0
[1.0.0]: https://github.com/christianjbrown/smartthings-api-sdk-php/releases/tag/v1.0.0
