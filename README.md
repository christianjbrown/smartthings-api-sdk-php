# SmartThings API Client

[![CI](https://github.com/christianjbrown/php-smartthings-api-lib/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/php-smartthings-api-lib/actions/workflows/ci.yml)

A strongly-typed PHP client for the [SmartThings API](https://developer.smartthings.com/). It lists the devices in your SmartThings account and reads a device's status, returning plain, typed model objects rather than raw arrays.

The client is **read-only** and currently supports:

- **Listing devices** — id, name, label, location and room ids, and each component's capabilities.
- **Reading a device's status** — currently the `temperatureMeasurement`, `relativeHumidityMeasurement`, and `battery` capabilities (value, unit, and timestamp) from the device's `main` component.
- **Listing locations** — id and name, or reading a single location by id (`getOneById`).
- **Reading a room** — id, name, and location id, either from a device (`getOneByDevice`) or by a location and room id (`getOneByLocationAndId`).



## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/php-smartthings-api-lib
```



## :computer: Usage

First, create a SmartThings [personal access token](https://account.smartthings.com/tokens) with the `devices` scopes. This token is passed to each API client.

The quickest way to get the two clients is the `SmartThings` entry point, which builds them (and their transformer chains) for you through a dependency-injection container — just pass your token:

```php
use ChristianBrown\SmartThings\SmartThings;

$smartThings     = new SmartThings('your-smartthings-personal-access-token');
$deviceApi       = $smartThings->getDeviceApi();  // DeviceApiInterface
$deviceStatusApi = $smartThings->getDeviceStatusApi();  // DeviceStatusApiInterface
$locationApi     = $smartThings->getLocationApi();  // LocationApiInterface
$locationRoomApi = $smartThings->getLocationRoomApi();  // LocationRoomApiInterface
```

If you'd rather wire the clients by hand, see [Wiring the clients](#wiring-the-clients) below.

With either approach, listing devices and reading a device's status looks like this:

```php
$devices = $deviceApi->getMultiple();                 // DeviceInterface[]
foreach ($devices as $device) {
    echo $device->getLabel() ?? $device->getName(), "\n";

    // The room the device is assigned to (skip devices with no room).
    // LocationRoomApi caches rooms by roomId, so devices sharing a room only hit the API once.
    if ($device->getRoomId() !== null) {
        $room = $locationRoomApi->getOneByDevice($device);   // LocationRoomInterface
        printf("  Room: %s\n", $room->getName());         // e.g. "Kitchen"
    }

    $status = $deviceStatusApi->getOneByDevice($device);     // DeviceStatusInterface

    $temp = $status->getTemperatureMeasurement()?->getTemperature();
    if ($temp !== null) {
        printf("  Temperature: %.1f°%s\n", $temp->getValue(), $temp->getUnit());
    }

    $humidity = $status->getRelativeHumidityMeasurement()?->getHumidity();
    if ($humidity !== null) {
        printf("  Humidity: %d%s\n", $humidity->getValue(), $humidity->getUnit());
    }

    $battery = $status->getBattery()?->getBattery();
    if ($battery !== null) {
        printf("  Battery: %d%s\n", $battery->getValue(), $battery->getUnit());
    }
}
```

You can also read a device's status by id, list locations, or fetch a room directly:

```php
$status = $deviceStatusApi->getOneById('a-device-id');     // DeviceStatusInterface

$locations = $locationApi->getMultiple();                       // LocationInterface[]
foreach ($locations as $location) {
    echo $location->getName(), "\n";
}

$location = $locationApi->getOneById('a-location-id');      // LocationInterface
echo $location->getName(), "\n";

$room = $locationRoomApi->getOneByLocationAndId($locations[0], 'a-room-id'); // LocationRoomInterface
echo $room->getName(), "\n";
```

## :rotating_light: Error handling

Everything this library throws implements `ChristianBrown\SmartThings\Exception\ExceptionInterface`, so a single `catch` covers it all:

```php
use ChristianBrown\SmartThings\Exception\ExceptionInterface;

try {
    $devices = $deviceApi->getMultiple();
} catch (ExceptionInterface $exception) {
    // Anything this library throws lands here.
}
```

There are two concrete types:

- **`UnexpectedResponseException`** (extends `RuntimeException`) — the SmartThings API returned a body the client or a transformer couldn't parse (a missing/mis-typed field, an empty response).
- **`MissingInputException`** (extends `InvalidArgumentException`) — bad caller input, e.g. passing a `DeviceInterface` with no location or room id to `LocationRoomApi::getOneByDevice()`.

Both live in `src/Exception/`. Request-level failures (network errors, non-2xx responses) still surface as `RequestExceptionInterface` from [`christianjbrown/php-api-client-lib`](https://github.com/christianjbrown/php-api-client-lib), which is outside this library's exception hierarchy.

Under the hood, `SmartThings` wires the clients and their transformer chains through a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container. If you don't want the container, you can build the same chains by hand — as shown below. The HTTP request sender comes from [`christianjbrown/php-api-client-lib`](https://github.com/christianjbrown/php-api-client-lib).

<details id="wiring-the-clients">
<summary><strong>Wiring the clients</strong></summary>

```php
use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Transformer\DevicesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTemperatureTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;

$apiToken = 'your-smartthings-personal-access-token';

// Shared JSON request sender (wires Guzzle for you).
$requestSender = (new ApiClient())->getJsonApiRequestSender();

// Devices client.
$deviceApi = new DeviceApi(
    $requestSender,
    new DevicesTransformer(
        new DeviceTransformer(
            new DeviceComponentsTransformer(
                new DeviceComponentTransformer(
                    new DeviceComponentCapabilitiesTransformer(
                        new DeviceComponentCapabilityTransformer()
                    )
                )
            )
        )
    ),
    $apiToken
);

// Device status client.
$deviceStatusApi = new DeviceStatusApi(
    $requestSender,
    new DeviceStatusTransformer(
        new DeviceStatusTemperatureMeasurementTransformer(
            new DeviceStatusTemperatureMeasurementTemperatureTransformer()
        ),
        new DeviceStatusRelativeHumidityMeasurementTransformer(
            new DeviceStatusRelativeHumidityMeasurementHumidityTransformer()
        ),
        new DeviceStatusBatteryTransformer(
            new DeviceStatusBatteryBatteryTransformer()
        )
    ),
    $apiToken
);

// Locations client.
$locationApi = new LocationApi(
    $requestSender,
    new LocationTransformer(),
    new LocationsTransformer(
        new LocationTransformer()
    ),
    $apiToken
);

// Location rooms client.
$locationRoomApi = new LocationRoomApi(
    $requestSender,
    new LocationRoomTransformer(),
    $apiToken
);
```

</details>

## :page_facing_up: License

Released under the [MIT License](LICENSE).
