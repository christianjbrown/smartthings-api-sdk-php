# SmartThings API SDK

[![CI](https://github.com/christianjbrown/smartthings-api-sdk-php/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/smartthings-api-sdk-php/actions/workflows/ci.yml) [![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen)](https://github.com/christianjbrown/smartthings-api-sdk-php/actions/workflows/ci.yml) [![Packagist](https://img.shields.io/packagist/v/christianjbrown/smartthings-api-sdk)](https://packagist.org/packages/christianjbrown/smartthings-api-sdk) [![License](https://img.shields.io/packagist/l/christianjbrown/smartthings-api-sdk)](https://github.com/christianjbrown/smartthings-api-sdk-php/blob/main/LICENSE) [![PHP](https://img.shields.io/packagist/dependency-v/christianjbrown/smartthings-api-sdk/php)](https://packagist.org/packages/christianjbrown/smartthings-api-sdk)

A strongly-typed PHP client for the [SmartThings API](https://developer.smartthings.com/). It lists the devices in your SmartThings account, reads a device's status, and — for the operations below marked as writes — lets you act on them: run device commands, switch a location's mode, and execute scenes and rules. It returns plain, typed model objects rather than raw arrays.

The client currently supports:

- **Listing devices** — id, name, label, location and room ids, and each component's capabilities — or reading a single device by id (`getOneById`). **Write:** executing one or more capability commands on a device (`executeCommands`), returning each command's tracking id and status; installing a SmartApp-managed device (`installDevice`); updating a device's label, location, room, components (id, label, icon and categories) or indoor map position (`updateDevice`); deleting a device (`deleteDevice`); and posting attribute-state events for a SmartApp-managed device (`createEvents`).
- **Reading a device's status** — currently the `temperatureMeasurement`, `relativeHumidityMeasurement`, and `battery` capabilities (value, unit, and timestamp) from the device's `main` component (`getOneById`/`getOneByDevice`), a single component (`getOneByComponent`), or a single capability on a component (`getOneByCapability`).
- **Reading a device's health** — the connection `state` (`ONLINE`/`OFFLINE`/`UNHEALTHY`) and the `lastUpdatedDate`, by id (`getOneById`) or from a device (`getOneByDevice`).
- **Reading a device's preferences** — the device's current preference values, by id (`getOneById`) or from a device (`getOneByDevice`). Each preference carries its name, `preferenceType`, and value.
- **Reading device preference definitions** — the account's custom device-preference definitions, optionally filtered by namespace (`getMultiple`), or a single definition by id (`getOneById`). Each carries its preference id, name, title, description, `preferenceType`, and required flag. **Write:** creating (`createPreference`), updating (`updatePreferenceById`) and deleting (`deletePreferenceById`) a preference. A preference's `definition` varies by `preferenceType` (minimum/maximum for `integer`/`number`, minLength/maxLength/stringType for `string`, options for `enumeration`, a default for any type), so `PreferenceRequest` accepts it as a raw array shaped per the [vendor's schema](https://developer.smartthings.com/docs/api/public/#operation/createPreference) rather than a fully typed nested model, for the same proportionality reason as Rules and Device profiles. Localizations are written with `createPreferenceLocalization` and `updatePreferenceLocalization` (`POST /preferences/{preferenceId}/i18n`, `PUT /preferences/{preferenceId}/i18n/{locale}`, the paths in the vendor spec).
- **Listing locations** — id and name, or reading a single location by id (`getOneById`). **Write:** creating a location (`createLocation`); replacing a location's fields (`updateLocation`); patching a location's latitude, longitude or region radius, including clearing a field (`patchLocation`); and deleting a location (`deleteLocation`).
- **Reading rooms** — listing every room in a location (`getMultiple`), reading a single room, either from a device (`getOneByDevice`) or by a location and room id (`getOneByLocationAndId`), or listing the devices in a room (`getDevicesInRoom`). Each room carries its id, name, and location id. **Write:** creating a room (`createRoom`), updating its name (`updateRoom`), and deleting it (`deleteRoom`).
- **Reading modes** — listing a location's modes (`getMultiple`), reading the currently active mode (`getCurrent`), or a single mode by id (`getOneByLocationAndId`). Each mode carries its id, label, and name. **Write:** switching the location's currently active mode (`changeCurrent`), which can trigger any automations for which the new mode is a trigger; creating a mode (`createMode`), updating its label (`updateMode`), and deleting it (`deleteMode`).
- **Reading scenes** — listing scenes for the account, optionally filtered by location (`getMultiple`), or a single scene by id (`getOneById`). Each scene carries its id, name, and location id. **Write:** executing a scene (`execute`), running each of its actions.
- **Reading rules** — listing a location's rules (`getMultiple`) or a single rule by id (`getOneById`); both require a location id. Each rule carries its id, name, and status. **Write:** triggering Rule execution (`execute`), returning the execution id and result; creating (`createRule`), updating (`updateRule`) and deleting (`deleteRule`) a Rule; and deleting every Rule in a location (`deleteAllRules`). The vendor's Rule action and condition schema is a recursive expression language (if, sleep, command, scene, every, location, limit and toggle actions, each of which can nest further actions and conditions). `RuleRequest::getActions()` accepts either typed `ActionInterface` objects or raw arrays shaped per the [vendor's Action schema](https://developer.smartthings.com/docs/api/public/#operation/createRule), and an action sequence can be set with `setActionSequence`. Rules read back through the typed `Action` tree as well.
- **Reading capabilities** — listing all platform capabilities (`getMultiple`), the custom capabilities in a namespace (`getMultipleByNamespace`), every capability namespace (`getNamespaces`), the versions of a capability (`getVersions`), one capability definition by id and version (`getOneByIdAndVersion`), or a capability's presentation by id and version (`getPresentation`). Each capability carries its id, name, status, version and ephemeral flag, plus its attributes and commands as typed models (schemas, enum commands and arguments); localizations read back with their preference options and capability attribute and command labels; each namespace its name, owner type, and owner id; each presentation its id and version. **Write:** creating a custom capability, optionally in a namespace and for an organization (`createCapability`); updating (`updateCapability`) and deleting (`deleteCapability`) a capability version; creating (`createCapabilityLocalization`), replacing (`updateCapabilityLocalization`) and patching (`patchCapabilityLocalization`) a localization; and creating (`createCustomCapabilityPresentation`) or replacing (`updateCustomCapabilityPresentation`) a custom capability's presentation. A capability's attributes and commands are typed models, and the presentation sections (dashboard, detail view, automation, presentation settings) are typed models on the create and update requests, shaped per the [vendor schema](https://developer.smartthings.com/docs/api/public/#operation/createCustomCapabilityPresentation), and a presentation read back carries the same sections as typed models.
- **Reading device profiles** — listing the account's device profiles (`getMultiple`) or a single profile by id (`getOneById`). Each carries its id, name, and status. **Write:** creating (`createDeviceProfile`), updating (`updateDeviceProfile`) and deleting (`deleteDeviceProfile`) a profile. A profile's `components` can be typed `DeviceProfileComponentRequestInterface` objects (each with typed capability references) or raw arrays, and its `preferences` can be typed `PreferenceRequestInterface` objects or raw arrays, all shaped per the [vendor's schema](https://developer.smartthings.com/docs/api/public/#operation/createDeviceProfile). A preference's definition can be set as a typed `PreferenceDefinitionInterface` with `setDefinitionModel`. `metadata` and `deviceConfig` are still accepted as raw arrays. A profile read back carries its components, preferences and detail fields as typed models.
- **Reading presentations** — a device presentation by presentation id (`getOne`) or for a specific device (`getByDeviceId`, or `getByDevice` from a device), a stored device config (`getDeviceConfig`), or the default config generated from a device type (`getDeviceConfigByType`). Each carries its presentation id, manufacturer name, and type. **Typed device configurations:** `createDeviceConfiguration` creates a configuration from a typed `DeviceConfigurationRequestInterface` (a profile id or the vendor's dashboard, detail view and automation trees), `getDeviceConfiguration` reads one as typed models, `getDevicePresentation` reads a device's presentation (optionally limited to a view, with `If-None-Match` and `Accept-Language`), and `generateDeviceConfiguration` returns a draft for an integration type.
- **Reading apps** — listing the account's apps (`getMultiple`), one app by name or id (`getOneById`), an app's OAuth config (`getOauth` — client name, scopes, redirect URIs), or its settings map (`getSettings`). **Write:** creating an app (`createApp`, returning the app plus the OAuth client id and secret when OAuth was requested); updating it (`updateApp`); deleting it (`deleteApp`); replacing its settings (`updateAppSettings`) and OAuth config (`updateAppOauth`); generating a new OAuth client id and secret (`generateAppOauth`); confirming a webhook target (`register`); and changing the signature type (`updateSignatureType`). `createApp` and `updateApp` accept the `signatureType` and `requireConfirmation` options, and `createApp` an `accountId`.
- **Reading installed apps** — listing installed app instances, optionally by location (`getMultiple`), one instance by id (`getOneById`), the instance for the current token (`getMe`), its configurations (`getConfigs`), or a single configuration (`getConfig`). **Write:** deleting an installed app (`deleteInstallation`); sending SmartApp and dashboard card events to its clients (`createEvents`); and managing its coordinate aliases (`putCoordinateAlias`, `deleteCoordinateAlias`, and `getCoordinateAliasCapability` for the alias's capability data as the raw response).
- **Reading subscriptions** — listing an installed app's subscriptions (`getMultiple`) or a single subscription by id (`getOneById`). Each carries its id, installed app id, and source type. **Write:** creating a subscription (`saveSubscription`, from a `SubscriptionRequest` whose `sourceType` selects one typed detail model: device, capability, mode, device lifecycle, device health, security arm state, hub health or scene lifecycle), deleting one (`deleteSubscription`), and deleting all of an installed app's subscriptions, optionally limited to a device or mode (`deleteAllSubscriptions`).
- **Reading schedules** — listing an installed app's schedules (`getMultiple`) or a single schedule by name (`getOneByName`). Each carries its name and installed app id. **Write:** creating a once or cron schedule (`createSchedule`), deleting one (`deleteSchedule`), and deleting all of an installed app's schedules (`deleteSchedules`).
- **Reading ST Schema connectors** — listing the account's ST Schema (C2C) connectors (`getMultiple`), a single connector by id (`getOneById`), the installed connector instances in a location (`getInstalledMultiple`), a single installed instance by id (`getInstalledById`), or a connector's install page definition (`getInstallPage`). Connectors carry their endpoint app id, app name, partner name, certification status, and ST client id; installed instances their isaId, app/partner name, location id, page type, and OAuth link.
- **Reading Edge hubs** — a hub device by id (`getOneById` — id, name, EUI, owner, serial number, firmware version), its characteristics as a scalar name→value map (`getCharacteristics`), the drivers installed on a hub, optionally filtered by device (`getInstalledDrivers`), one installed driver by id (`getInstalledDriver`), or the channels a hub is enrolled in (`getEnrolledChannels`). **Write:** installing a driver on a hub, optionally from a channel (`installDrivers`); uninstalling one (`uninstallDriver`); changing the driver, integration profile or provisioning state of a child device (`updateHubDevice`, with the `forceUpdate` option); and deleting a hub by its EUI (`deleteHubByEui`).
- **Reading Edge channels** — listing driver-distribution channels, optionally filtered by type, subscriber id, or read-only inclusion (`getMultiple`), a single channel by id (`getOneById`), the drivers assigned to a channel (`getDrivers`), or the driver metadata for a channel/driver pair (`getDriverMeta`, returning a `DriverInterface`). Each channel carries its channel id, name, description, terms-of-service URL, and type. A single driver of a channel is read with `getDriverChannel`. **Write:** creating (`createChannel`), updating (`updateChannel`) and deleting (`deleteChannel`) a channel; and adding a driver version to a channel (`createDriverChannel`), changing its version (`updateDriverChannelVersion`) or removing it (`deleteDriverChannel`).
- **Reading Edge drivers** — listing the account's drivers (`getMultiple`), the drivers on the default channel (`getDefaults`), a single driver by id (`getOneById`), or a specific driver revision by id and version (`getOneByIdAndVersion`). Each carries its driver id, name, description, package key, and version. **Write:** deleting a driver (`deleteDriver`). Uploading a driver package (a zip archive) is `uploadDriverPackage`, which returns the created driver.
- **Reading virtual devices** — listing the account's virtual devices, optionally filtered by location (`getMultiple`). Each is returned as a `DeviceInterface`, the same typed model as a physical device.
- **Reading location services** — a location's service info (`getLocationInfo` — city, latitude, longitude, and subscriptions), the list of available service-capability names (`getAvailableCapabilities`), or the data for one or more capabilities such as `weather`, `airQuality`, and `forecast` (`getCapability` / `getCapabilities`). Each capability's fields are returned as a name-keyed map of typed `ServiceMeasurementInterface` values (value + unit). **Write:** creating (`createSubscription`), replacing (`updateSubscription`) and deleting (`deleteSubscription`) a location service subscription, and deleting the subscriptions of an installed schema app (`deleteSubscriptionsByInstalledApp`). The vendor's alert-link operation answers with an HTTP redirect whose `Location` header the API client does not expose, so it is not covered.
- **Text to speech** — the voices SmartThings offers (`TextToSpeechApi::getInfo`), converting text to speech and getting the audio URL (`convert`), and playing text on a device (`playText`).
- **Schema app invitations** — creating an invitation to a schema app (`SchemaAppInviteApi::createInvite`), accepting one by its short code (`acceptInvite`), listing a schema app's invitations a page at a time (`getInvites`), and checking whether an invitation was accepted (`checkAcceptance`).
- **More response fields** — the vendor's remaining read-only fields are now exposed on the existing response models, including the detail blocks on locations, rooms, modes, schedules, installed apps, apps, schema apps, subscriptions, Edge channels, drivers, hub drivers and device preference definitions. Each is optional and read through its own typed model, so payloads that omit it are unaffected. Devices now also carry their component-level detail (the app, BLE, Zigbee, Z-Wave, hub, Matter and other integration blocks the vendor defines) and their child devices, read through typed models.
- **Schema (Cloud-to-Cloud) connectors, writes** — creating a schema app (`createApp`, returning the generated SmartThings client id and secret), replacing it (`updateApp`), deleting it (`deleteApp`), deleting an installed schema app (`deleteInstalled`), generating new SmartThings OAuth credentials (`generateStOauthCredentials`), and listing the apps of a user (`getByUserId`) or organization (`getByOrganization`). The `X-ST-Organization` header is an optional argument wherever the vendor spec has it.
- **Reading organizations** — listing the account's organizations (`getMultiple`) or a single organization by id (`getOneById`). Each carries its organization id, name, label, manufacturer name, and default-user-org flag.
- **Reading translations (i18n)** — for capabilities, device profiles, and device preference definitions, list the locales a resource is translated into (`getLocales`) or read the translations for one locale/tag (`getTranslations`). Locales are returned as `LocaleReferenceInterface` (tag); translations as `LocalizationInterface` (tag, label, description).
- **Reading device history** — device event history (`getMultiple`), optionally filtered by device and/or location, oldest-first, transparently paged across the API's `_links.next` chain (with an optional page cap). Each event carries its device id, location id, component, capability, attribute, value, and epoch (the SmartThings history window is roughly the last 7 days).

### Supported endpoints

| Resource | Client | Endpoint(s) | Returns |
| --- | --- | --- | --- |
| Devices | `getDeviceApi()` | `GET /devices`, `GET /devices/{deviceId}`, `POST /devices/{deviceId}/commands`, `POST /devices`, `PUT /devices/{deviceId}`, `DELETE /devices/{deviceId}`, `POST /devices/{deviceId}/events` | `DeviceInterface[]` / `DeviceInterface` / `DeviceCommandResultInterface[]` |
| Virtual devices | `getVirtualDeviceApi()` | `GET /virtualdevices` | `DeviceInterface[]` |
| Device status | `getDeviceStatusApi()` | `GET /devices/{deviceId}/status`, `GET /devices/{deviceId}/components/{componentId}/status`, `GET /devices/{deviceId}/components/{componentId}/capabilities/{capabilityId}/status` | `DeviceStatusInterface` |
| Device health | `getDeviceHealthApi()` | `GET /devices/{deviceId}/health` | `DeviceHealthInterface` |
| Device preferences | `getDevicePreferencesApi()` | `GET /devices/{deviceId}/preferences` | `DevicePreferenceInterface[]` |
| Device preference definitions | `getDevicePreferenceDefinitionApi()` | `GET /devicepreferences`, `GET /devicepreferences/{preferenceId}`, `GET /devicepreferences/{id}/i18n`, `GET /devicepreferences/{id}/i18n/{locale}`, `POST /devicepreferences`, `PUT /devicepreferences/{preferenceId}`, `DELETE /devicepreferences/{preferenceId}`, `POST /preferences/{preferenceId}/i18n`, `PUT /preferences/{preferenceId}/i18n/{locale}` | `DevicePreferenceDefinitionInterface[]` / `DevicePreferenceDefinitionInterface` / `LocaleReferenceInterface[]` / `LocalizationInterface` |
| Device history | `getDeviceHistoryApi()` | `GET /history/devices` (paged) | `DeviceHistoryEventInterface[]` |
| Locations | `getLocationApi()` | `GET /locations`, `GET /locations/{locationId}`, `POST /locations`, `PUT /locations/{locationId}`, `PATCH /locations/{locationId}`, `DELETE /locations/{locationId}` | `LocationInterface[]` / `LocationInterface` |
| Rooms | `getLocationRoomApi()` | `GET /locations/{locationId}/rooms`, `GET /locations/{locationId}/rooms/{roomId}`, `GET /locations/{locationId}/rooms/{roomId}/devices`, `POST /locations/{locationId}/rooms`, `PUT /locations/{locationId}/rooms/{roomId}`, `DELETE /locations/{locationId}/rooms/{roomId}` | `LocationRoomInterface[]` / `LocationRoomInterface` / `DeviceInterface[]` |
| Modes | `getLocationModeApi()` | `GET /locations/{locationId}/modes`, `GET /locations/{locationId}/modes/current`, `GET /locations/{locationId}/modes/{modeId}`, `PUT /locations/{locationId}/modes/current`, `POST /locations/{locationId}/modes`, `PUT /locations/{locationId}/modes/{modeId}`, `DELETE /locations/{locationId}/modes/{modeId}` | `ModeInterface[]` / `ModeInterface` |
| Scenes | `getSceneApi()` | `GET /scenes`, `GET /scenes/{sceneId}`, `POST /scenes/{sceneId}/execute` | `SceneInterface[]` / `SceneInterface` / `SceneExecutionResultInterface` |
| Rules | `getRuleApi()` | `GET /rules?locationId=…`, `GET /rules/{ruleId}?locationId=…`, `POST /rules/execute/{ruleId}`, `POST /rules?locationId=…`, `PUT /rules/{ruleId}?locationId=…`, `DELETE /rules/{ruleId}?locationId=…`, `DELETE /rules?locationId=…` | `RuleInterface[]` / `RuleInterface` / `RuleExecutionResultInterface` |
| Capabilities | `getCapabilityApi()` | `GET /capabilities`, `GET /capabilities/namespaces`, `GET /capabilities/namespaces/{namespace}`, `GET /capabilities/{id}`, `GET /capabilities/{id}/{version}`, `GET /capabilities/{id}/{version}/presentation`, `GET /capabilities/{id}/{version}/i18n`, `GET /capabilities/{id}/{version}/i18n/{tag}`, `POST /capabilities`, `PUT /capabilities/{id}/{version}`, `DELETE /capabilities/{id}/{version}`, `POST /capabilities/{id}/{version}/i18n`, `PUT /capabilities/{id}/{version}/i18n/{locale}`, `PATCH /capabilities/{id}/{version}/i18n/{locale}`, `POST /capabilities/{id}/{version}/presentation`, `PUT /capabilities/{id}/{version}/presentation` | `CapabilityInterface[]` / `CapabilityInterface` / `CapabilityNamespaceInterface[]` / `CapabilityPresentationInterface` / `LocaleReferenceInterface[]` / `LocalizationInterface` |
| Device profiles | `getDeviceProfileApi()` | `GET /deviceprofiles`, `GET /deviceprofiles/{deviceProfileId}`, `GET /deviceprofiles/{id}/i18n`, `GET /deviceprofiles/{id}/i18n/{tag}`, `POST /deviceprofiles`, `PUT /deviceprofiles/{deviceProfileId}`, `DELETE /deviceprofiles/{deviceProfileId}` | `DeviceProfileInterface[]` / `DeviceProfileInterface` / `LocaleReferenceInterface[]` / `LocalizationInterface` |
| Presentation | `getPresentationApi()` | `GET /presentation`, `GET /presentation?deviceId=…`, `GET /presentation/deviceconfig`, `GET /presentation/types/{typeIntegrationId}/deviceconfig`, `POST /presentation/deviceconfig` | `PresentationInterface` / `DeviceConfigurationInterface` / `DevicePresentationInterface` / `CreateDeviceConfigRequestInterface` |
| Apps | `getAppApi()` | `GET /apps`, `GET /apps/{appNameOrId}`, `GET /apps/{appNameOrId}/oauth`, `GET /apps/{appNameOrId}/settings`, `POST /apps`, `PUT /apps/{appNameOrId}`, `DELETE /apps/{appNameOrId}`, `PUT /apps/{appNameOrId}/settings`, `PUT /apps/{appNameOrId}/oauth`, `POST /apps/{appNameOrId}/oauth/generate`, `PUT /apps/{appNameOrId}/register`, `PUT /apps/{appNameOrId}/signature-type` | `AppInterface[]` / `AppInterface` / `AppOauthInterface` / `AppSettingsInterface` |
| Installed apps | `getInstalledAppApi()` | `GET /installedapps`, `GET /installedapps/{id}`, `GET /installedapps/me`, `GET /installedapps/{id}/configs`, `GET /installedapps/{id}/configs/{configurationId}`, `DELETE /installedapps/{id}`, `POST /installedapps/{id}/events`, `PUT /installedapps/{id}/alias/{aliasName}`, `DELETE /installedapps/{id}/alias/{aliasName}`, `GET /installedapps/{id}/alias/{aliasName}/capability` | `InstalledAppInterface[]` / `InstalledAppInterface` / `InstalledAppConfigInterface[]` / `InstalledAppConfigInterface` |
| Subscriptions | `getSubscriptionApi()` | `GET /installedapps/{id}/subscriptions`, `GET /installedapps/{id}/subscriptions/{subscriptionId}`, `POST /installedapps/{id}/subscriptions`, `DELETE /installedapps/{id}/subscriptions/{subscriptionId}`, `DELETE /installedapps/{id}/subscriptions` | `SubscriptionInterface[]` / `SubscriptionInterface` |
| Schedules | `getScheduleApi()` | `GET /installedapps/{id}/schedules`, `GET /installedapps/{id}/schedules/{scheduleName}`, `POST /installedapps/{id}/schedules`, `DELETE /installedapps/{id}/schedules/{scheduleName}`, `DELETE /installedapps/{id}/schedules` | `ScheduleInterface[]` / `ScheduleInterface` |
| Organizations | `getOrganizationApi()` | `GET /organizations`, `GET /organizations/{organizationId}` | `OrganizationInterface[]` / `OrganizationInterface` |
| Location services | `getServiceApi()` | `GET /services/coordinate/locations/{id}`, `GET /services/coordinate/locations/{id}/capabilities` (list and `?name=…`), `POST /services/coordinate/locations/{id}/subscriptions`, `PUT /services/coordinate/locations/{id}/subscriptions/{subscriptionId}`, `DELETE /services/coordinate/locations/{id}/subscriptions/{subscriptionId}`, `DELETE /services/coordinate/locations/{id}/subscriptions?isaId=…` | `ServiceLocationInfoInterface` / `string[]` / `ServiceCapabilityDataInterface` |
| Edge drivers | `getDriverApi()` | `GET /drivers`, `GET /drivers/default`, `GET /drivers/{driverId}`, `GET /drivers/{driverId}/versions/{version}`, `DELETE /drivers/{driverId}`, `POST /drivers/package` | `DriverInterface[]` / `DriverInterface` |
| Text to speech | `getTextToSpeechApi()` | `GET /services/tts/info`, `POST /services/tts`, `POST /services/tts/playtext` | `TtsInfoInterface` / `ConvertedTtsInterface` / `PlayedTextInterface` |
| Schema app invitations | `getSchemaAppInviteApi()` | `POST /invites/schemaApp`, `PUT /invites/schemaApp/{shortCode}/accept`, `GET /invites/schemaApp`, `GET /invites/schemaApp/checkAcceptance` | `SchemaAppInviteReceiptInterface` / `SchemaAppInviteAcceptanceInterface` / `SchemaAppInvitePageInterface` / `SchemaAppInviteStatusInterface` |
| Edge channels | `getChannelApi()` | `GET /distchannels`, `GET /distchannels/{channelId}`, `GET /distchannels/{channelId}/drivers`, `GET /distchannels/{channelId}/drivers/{driverId}/meta`, `GET /distchannels/{channelId}/drivers/{driverId}`, `POST /distchannels`, `PUT /distchannels/{channelId}`, `DELETE /distchannels/{channelId}`, `POST /distchannels/{channelId}/drivers`, `PUT /distchannels/{channelId}/drivers/{driverId}`, `DELETE /distchannels/{channelId}/drivers/{driverId}` | `ChannelInterface[]` / `ChannelInterface` / `ChannelDriverInterface[]` / `DriverInterface` |
| Edge hubs | `getHubApi()` | `GET /hubdevices/{hubId}`, `GET /hubdevices/{hubId}/characteristics`, `GET /hubdevices/{hubId}/drivers`, `GET /hubdevices/{hubId}/drivers/{driverId}`, `GET /hubdevices/{hubId}/channels`, `PUT /hubdevices/{hubId}/drivers/{driverId}`, `DELETE /hubdevices/{hubId}/drivers/{driverId}`, `PATCH /hubdevices/{hubId}/childdevice/{deviceId}`, `DELETE /hubdevices/eui/{hubEui}` | `HubInterface` / scalar map / `HubInstalledDriverInterface[]` / `HubInstalledDriverInterface` / `HubEnrolledChannelInterface[]` |
| ST Schema connectors | `getSchemaConnectorApi()` | `GET /schema/apps`, `GET /schema/apps/{id}`, `GET /schema/install/{id}`, `GET /schema/installedapps/location/{locationId}`, `GET /schema/installedapps/{id}`, `GET /schema/apps/user/{userId}`, `GET /schema/apps/organizations`, `POST /schema/apps`, `PUT /schema/apps/{endpointAppId}`, `DELETE /schema/apps/{endpointAppId}`, `DELETE /schema/installedapps/{isaId}`, `POST /schema/oauth/stclient/credentials` | `SchemaAppInterface[]` / `SchemaAppInterface` / `SchemaPageInterface` / `InstalledSchemaAppInterface[]` / `InstalledSchemaAppInterface` |



## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.



## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/smartthings-api-sdk
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
$deviceHistoryApi = $smartThings->getDeviceHistoryApi();  // DeviceHistoryApiInterface
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
$scheduleApi     = $smartThings->getScheduleApi();  // ScheduleApiInterface
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

### Writing: commands, modes, scenes, and rules

```php
use ChristianBrown\SmartThings\Model\DeviceCommand;

// Run one or more capability commands on a device.
$commandResults = $deviceApi->executeCommands('a-device-id', [
    new DeviceCommand('switch', 'on'),
    (new DeviceCommand('switchLevel', 'setLevel'))->setArguments([80]),
]); // DeviceCommandResultInterface[]
foreach ($commandResults as $commandResult) {
    echo $commandResult->getStatus() ?? 'unknown', "\n"; // e.g. "ACCEPTED"
}

// Switch a location's currently active mode.
$mode = $locationModeApi->changeCurrent($locations[0], 'a-mode-id'); // ModeInterface
echo $mode->getLabel(), "\n";

// Execute a scene.
$sceneResult = $sceneApi->execute('a-scene-id'); // SceneExecutionResultInterface
echo $sceneResult->getStatus() ?? 'unknown', "\n"; // e.g. "success"

// Trigger a rule.
$ruleResult = $ruleApi->execute('a-rule-id'); // RuleExecutionResultInterface
echo $ruleResult->getResult() ?? 'unknown', "\n"; // e.g. "Success"
```

### Filtering and query parameters

List and get calls take the API's optional query parameters. The busier lists take a small query
object; the rest take plain optional arguments after `$skipCache`. Lists such as `capability` or
`driverIds` are sent as repeated parameters, as the API expects.

```php
use ChristianBrown\SmartThings\Model\DeviceListQuery;

$query = (new DeviceListQuery())
    ->setCapabilities(['switch', 'switchLevel'])
    ->setCapabilitiesMode('or')
    ->setIncludeStatus(true);
$devices = $deviceApi->getMultiple(null, false, $query);

$device = $deviceApi->getOneById('a-device-id', false, true); // includeStatus
```

The other query objects are `InstalledAppListQuery`, `AppListQuery`, `RuleListQuery`,
`LocationListQuery` and `PreferenceListQuery`. Each response is cached per full request, so
the same call with a different filter is fetched again.

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

Both live in `src/Exception/`. Request-level failures (network errors, non-2xx responses) still surface as `RequestExceptionInterface` from [`christianjbrown/api-client`](https://github.com/christianjbrown/api-client-php), which is outside this library's exception hierarchy.

Under the hood, `SmartThings` wires the clients and their transformer chains through a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container. If you don't want the container, you can build the same chains by hand — as shown below. The HTTP request sender comes from [`christianjbrown/api-client`](https://github.com/christianjbrown/api-client-php).

### Overriding the API host

Every request goes to `https://api.smartthings.com` by default. To point at a different host — a
staging environment, a proxy, a recorded-fixture server in a test suite — pass an `ApiHostInterface`
as the second constructor argument:

```php
use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\SmartThings;

$smartThings = new SmartThings(
    'your-smartthings-personal-access-token',
    new ApiHost('https://staging.example.com')
);
```

Omit it, or pass `null`, and requests go to production exactly as before — existing callers don't
need to change anything. `ApiHostInterface::PRODUCTION_BASE_URL` holds the default. The interface
constants on each `*ApiInterface` (e.g. `DeviceApiInterface::API_URL`) still point at production and
are unaffected by an override; the override only changes the host each request is actually sent to.

<details id="wiring-the-clients">
<summary><strong>Wiring the clients</strong></summary>

The `SmartThings` facade builds and wires every client, and that is the supported way to use the
library. If you construct a client yourself, every collaborator is a required constructor
argument: the JSON request sender, the client's transformers, a `Token`, and, for the operations
that write, the request serializers and response transformers. The registrars under
`src/DependencyInjection/Registrar/` show the exact wiring of each client. For example, the scenes
client:

```php
use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\SmartThings\Api\SceneApi;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Transformer\SceneExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\ScenesTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;

$sceneTransformer = new SceneTransformer();

$sceneApi = new SceneApi(
    (new ApiClient())->getJsonApiRequestSender(),
    $sceneTransformer,
    new ScenesTransformer($sceneTransformer),
    new Token($apiToken),
    new SceneExecutionResultTransformer()
);
```

</details>

## :arrow_up: Upgrading to 2.0

Version 2.0 removes the built-in fallbacks: a client no longer builds a default serializer or
transformer for a collaborator you leave out. Every collaborator of an `*Api` class, and of the
transformers and serializers that take collaborators, is now a required constructor argument
typed on its interface. Code that uses the `SmartThings` facade (`new SmartThings($token)` and the
`get*Api()` getters) is unaffected, because the facade's registrars wire everything. Code that
constructs `*Api` classes by hand has to pass the collaborators, including the
`RequestUrlBuilderInterface` that the clients with query parameters take; the registrars list them.

## :page_facing_up: License

Released under the [MIT License](LICENSE).
