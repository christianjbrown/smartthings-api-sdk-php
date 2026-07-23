# SmartThings API Client

[![CI](https://github.com/christianjbrown/php-smartthings-api-lib/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/php-smartthings-api-lib/actions/workflows/ci.yml)

A strongly-typed PHP client for the [SmartThings API](https://developer.smartthings.com/). It lists the devices in your SmartThings account and reads a device's status, returning plain, typed model objects rather than raw arrays.

The client is **read-only** and currently supports:

- **Listing devices** — id, name, label, location and room ids, and each component's capabilities — or reading a single device by id (`getOneById`).
- **Reading a device's status** — currently the `temperatureMeasurement`, `relativeHumidityMeasurement`, and `battery` capabilities (value, unit, and timestamp) from the device's `main` component (`getOneById`/`getOneByDevice`), a single component (`getOneByComponent`), or a single capability on a component (`getOneByCapability`).
- **Reading a device's health** — the connection `state` (`ONLINE`/`OFFLINE`/`UNHEALTHY`) and the `lastUpdatedDate`, by id (`getOneById`) or from a device (`getOneByDevice`).
- **Listing locations** — id and name, or reading a single location by id (`getOneById`).
- **Reading rooms** — listing every room in a location (`getMultiple`), or reading a single room, either from a device (`getOneByDevice`) or by a location and room id (`getOneByLocationAndId`). Each room carries its id, name, and location id.
- **Reading modes** — listing a location's modes (`getMultiple`), reading the currently active mode (`getCurrent`), or a single mode by id (`getOneByLocationAndId`). Each mode carries its id, label, and name.
- **Reading scenes** — listing scenes for the account, optionally filtered by location (`getMultiple`), or a single scene by id (`getOneById`). Each scene carries its id, name, and location id.
- **Reading rules** — listing a location's rules (`getMultiple`) or a single rule by id (`getOneById`); both require a location id. Each rule carries its id, name, and status.
- **Reading capabilities** — listing all platform capabilities (`getMultiple`), the custom capabilities in a namespace (`getMultipleByNamespace`), or one capability definition by id and version (`getOneByIdAndVersion`). Each carries its id, name, status, and version.
- **Reading device profiles** — listing the account's device profiles (`getMultiple`) or a single profile by id (`getOneById`). Each carries its id, name, and status.
- **Reading presentations** — a device presentation by presentation id (`getOne`), a stored device config (`getDeviceConfig`), or the default config generated from a device type (`getDeviceConfigByType`). Each carries its presentation id, manufacturer name, and type.
- **Reading apps** — listing the account's apps (`getMultiple`), one app by name or id (`getOneById`), an app's OAuth config (`getOauth` — client name, scopes, redirect URIs), or its settings map (`getSettings`).
- **Reading installed apps** — listing installed app instances, optionally by location (`getMultiple`), one instance by id (`getOneById`), its configurations (`getConfigs`), or a single configuration (`getConfig`).
- **Reading subscriptions** — listing an installed app's subscriptions (`getMultiple`) or a single subscription by id (`getOneById`). Each carries its id, installed app id, and source type.

### Supported endpoints

| Resource | Client | Endpoint(s) | Returns |
| --- | --- | --- | --- |
| Devices | `getDeviceApi()` | `GET /devices`, `GET /devices/{deviceId}` | `DeviceInterface[]` / `DeviceInterface` |
| Device status | `getDeviceStatusApi()` | `GET /devices/{deviceId}/status`, `GET /devices/{deviceId}/components/{componentId}/status`, `GET /devices/{deviceId}/components/{componentId}/capabilities/{capabilityId}/status` | `DeviceStatusInterface` |
| Device health | `getDeviceHealthApi()` | `GET /devices/{deviceId}/health` | `DeviceHealthInterface` |
| Locations | `getLocationApi()` | `GET /locations`, `GET /locations/{locationId}` | `LocationInterface[]` / `LocationInterface` |
| Rooms | `getLocationRoomApi()` | `GET /locations/{locationId}/rooms`, `GET /locations/{locationId}/rooms/{roomId}` | `LocationRoomInterface[]` / `LocationRoomInterface` |
| Modes | `getLocationModeApi()` | `GET /locations/{locationId}/modes`, `GET /locations/{locationId}/modes/current`, `GET /locations/{locationId}/modes/{modeId}` | `ModeInterface[]` / `ModeInterface` |
| Scenes | `getSceneApi()` | `GET /scenes`, `GET /scenes/{sceneId}` | `SceneInterface[]` / `SceneInterface` |
| Rules | `getRuleApi()` | `GET /rules?locationId=…`, `GET /rules/{ruleId}?locationId=…` | `RuleInterface[]` / `RuleInterface` |
| Capabilities | `getCapabilityApi()` | `GET /capabilities`, `GET /capabilities/namespaces/{namespace}`, `GET /capabilities/{id}/{version}` | `CapabilityInterface[]` / `CapabilityInterface` |
| Device profiles | `getDeviceProfileApi()` | `GET /deviceprofiles`, `GET /deviceprofiles/{deviceProfileId}` | `DeviceProfileInterface[]` / `DeviceProfileInterface` |
| Presentation | `getPresentationApi()` | `GET /presentation`, `GET /presentation/deviceconfig`, `GET /presentation/types/{typeIntegrationId}/deviceconfig` | `PresentationInterface` |
| Apps | `getAppApi()` | `GET /apps`, `GET /apps/{appNameOrId}`, `GET /apps/{appNameOrId}/oauth`, `GET /apps/{appNameOrId}/settings` | `AppInterface[]` / `AppInterface` / `AppOauthInterface` / `AppSettingsInterface` |
| Installed apps | `getInstalledAppApi()` | `GET /installedapps`, `GET /installedapps/{id}`, `GET /installedapps/{id}/configs`, `GET /installedapps/{id}/configs/{configurationId}` | `InstalledAppInterface[]` / `InstalledAppInterface` / `InstalledAppConfigInterface[]` / `InstalledAppConfigInterface` |
| Subscriptions | `getSubscriptionApi()` | `GET /installedapps/{id}/subscriptions`, `GET /installedapps/{id}/subscriptions/{subscriptionId}` | `SubscriptionInterface[]` / `SubscriptionInterface` |



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
$deviceHealthApi = $smartThings->getDeviceHealthApi();  // DeviceHealthApiInterface
$locationApi     = $smartThings->getLocationApi();  // LocationApiInterface
$locationModeApi = $smartThings->getLocationModeApi();  // LocationModeApiInterface
$locationRoomApi = $smartThings->getLocationRoomApi();  // LocationRoomApiInterface
$sceneApi        = $smartThings->getSceneApi();  // SceneApiInterface
$ruleApi         = $smartThings->getRuleApi();  // RuleApiInterface
$capabilityApi   = $smartThings->getCapabilityApi();  // CapabilityApiInterface
$deviceProfileApi = $smartThings->getDeviceProfileApi();  // DeviceProfileApiInterface
$presentationApi = $smartThings->getPresentationApi();  // PresentationApiInterface
$appApi          = $smartThings->getAppApi();  // AppApiInterface
$installedAppApi = $smartThings->getInstalledAppApi();  // InstalledAppApiInterface
$subscriptionApi = $smartThings->getSubscriptionApi();  // SubscriptionApiInterface
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

    $health = $deviceHealthApi->getOneByDevice($device);     // DeviceHealthInterface
    printf("  Health: %s\n", $health->getState() ?? 'unknown');   // e.g. "ONLINE"
}
```

You can also read a single device or its status by id, list locations, or list and fetch rooms directly:

```php
$device = $deviceApi->getOneById('a-device-id');           // DeviceInterface
echo $device->getLabel() ?? $device->getName(), "\n";

$status = $deviceStatusApi->getOneById('a-device-id');     // DeviceStatusInterface

$locations = $locationApi->getMultiple();                       // LocationInterface[]
foreach ($locations as $location) {
    echo $location->getName(), "\n";
}

$location = $locationApi->getOneById('a-location-id');      // LocationInterface
echo $location->getName(), "\n";

$rooms = $locationRoomApi->getMultiple($locations[0]);          // LocationRoomInterface[]
foreach ($rooms as $room) {
    echo $room->getName(), "\n";
}

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
use ChristianBrown\SmartThings\Api\AppApi;
use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceHealthApi;
use ChristianBrown\SmartThings\Api\DeviceProfileApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\InstalledAppApi;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\PresentationApi;
use ChristianBrown\SmartThings\Api\RuleApi;
use ChristianBrown\SmartThings\Api\SceneApi;
use ChristianBrown\SmartThings\Api\SubscriptionApi;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformer;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppsTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DevicesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTemperatureTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\ModesTransformer;
use ChristianBrown\SmartThings\Transformer\ModeTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationTransformer;
use ChristianBrown\SmartThings\Transformer\RulesTransformer;
use ChristianBrown\SmartThings\Transformer\RuleTransformer;
use ChristianBrown\SmartThings\Transformer\ScenesTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformer;

$apiToken = 'your-smartthings-personal-access-token';

// Shared JSON request sender (wires Guzzle for you).
$requestSender = (new ApiClient())->getJsonApiRequestSender();

// Apps client. The list endpoint wraps the single app transformer in an
// AppsTransformer; the oauth and settings endpoints get their own transformers.
$appTransformer = new AppTransformer();

$appApi = new AppApi(
    $requestSender,
    $appTransformer,
    new AppsTransformer($appTransformer),
    new AppOauthTransformer(),
    new AppSettingsTransformer(),
    $apiToken
);

// Capabilities client. The single capability transformer is shared: the list
// endpoints wrap it in a CapabilitiesTransformer, and getOneByIdAndVersion() uses
// it directly.
$capabilityTransformer = new CapabilityTransformer();

$capabilityApi = new CapabilityApi(
    $requestSender,
    $capabilityTransformer,
    new CapabilitiesTransformer($capabilityTransformer),
    $apiToken
);

// Devices client. The single device transformer is shared: the list endpoint wraps
// it in a DevicesTransformer, and getOneById() uses it directly.
$deviceTransformer = new DeviceTransformer(
    new DeviceComponentsTransformer(
        new DeviceComponentTransformer(
            new DeviceComponentCapabilitiesTransformer(
                new DeviceComponentCapabilityTransformer()
            )
        )
    )
);

$deviceApi = new DeviceApi(
    $requestSender,
    $deviceTransformer,
    new DevicesTransformer($deviceTransformer),
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

// Device health client.
$deviceHealthApi = new DeviceHealthApi(
    $requestSender,
    new DeviceHealthTransformer(),
    $apiToken
);

// Device profiles client. The single profile transformer is shared: the list
// endpoint wraps it in a DeviceProfilesTransformer, and getOneById() uses it directly.
$deviceProfileTransformer = new DeviceProfileTransformer();

$deviceProfileApi = new DeviceProfileApi(
    $requestSender,
    $deviceProfileTransformer,
    new DeviceProfilesTransformer($deviceProfileTransformer),
    $apiToken
);

// Installed apps client. The list endpoint wraps the single transformer in an
// InstalledAppsTransformer; the config endpoints have their own single/collection pair.
$installedAppTransformer = new InstalledAppTransformer();
$installedAppConfigTransformer = new InstalledAppConfigTransformer();

$installedAppApi = new InstalledAppApi(
    $requestSender,
    $installedAppTransformer,
    new InstalledAppsTransformer($installedAppTransformer),
    $installedAppConfigTransformer,
    new InstalledAppConfigsTransformer($installedAppConfigTransformer),
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

// Location modes client. The single mode transformer is shared: the list endpoint
// wraps it in a ModesTransformer, and the single/current reads use it directly.
$modeTransformer = new ModeTransformer();

$locationModeApi = new LocationModeApi(
    $requestSender,
    $modeTransformer,
    new ModesTransformer($modeTransformer),
    $apiToken
);

// Location rooms client. The single room transformer is shared: the list endpoint
// wraps it in a LocationRoomsTransformer, and the single-room reads use it directly.
$locationRoomTransformer = new LocationRoomTransformer();

$locationRoomApi = new LocationRoomApi(
    $requestSender,
    $locationRoomTransformer,
    new LocationRoomsTransformer($locationRoomTransformer),
    $apiToken
);

// Scenes client. The single scene transformer is shared: the list endpoint wraps
// it in a ScenesTransformer, and getOneById() uses it directly.
$sceneTransformer = new SceneTransformer();

$sceneApi = new SceneApi(
    $requestSender,
    $sceneTransformer,
    new ScenesTransformer($sceneTransformer),
    $apiToken
);

// Rules client. The single rule transformer is shared: the list endpoint wraps
// it in a RulesTransformer, and getOneById() uses it directly. Both reads require
// a location id.
$ruleTransformer = new RuleTransformer();

$ruleApi = new RuleApi(
    $requestSender,
    $ruleTransformer,
    new RulesTransformer($ruleTransformer),
    $apiToken
);

// Subscriptions client. The single subscription transformer is shared: the list
// endpoint wraps it in a SubscriptionsTransformer, and getOneById() uses it directly.
$subscriptionTransformer = new SubscriptionTransformer();

$subscriptionApi = new SubscriptionApi(
    $requestSender,
    $subscriptionTransformer,
    new SubscriptionsTransformer($subscriptionTransformer),
    $apiToken
);

// Presentation client. A single transformer serves all three read methods.
$presentationApi = new PresentationApi(
    $requestSender,
    new PresentationTransformer(),
    $apiToken
);
```

</details>

## :page_facing_up: License

Released under the [MIT License](LICENSE).
