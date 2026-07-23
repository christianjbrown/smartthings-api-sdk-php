<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests;

use ChristianBrown\SmartThings\Api\AppApi;
use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\ChannelApi;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceHealthApi;
use ChristianBrown\SmartThings\Api\DeviceHistoryApi;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApi;
use ChristianBrown\SmartThings\Api\DevicePreferencesApi;
use ChristianBrown\SmartThings\Api\DeviceProfileApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\DriverApi;
use ChristianBrown\SmartThings\Api\HubApi;
use ChristianBrown\SmartThings\Api\InstalledAppApi;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\OrganizationApi;
use ChristianBrown\SmartThings\Api\PresentationApi;
use ChristianBrown\SmartThings\Api\RuleApi;
use ChristianBrown\SmartThings\Api\SceneApi;
use ChristianBrown\SmartThings\Api\ScheduleApi;
use ChristianBrown\SmartThings\Api\SchemaConnectorApi;
use ChristianBrown\SmartThings\Api\ServiceApi;
use ChristianBrown\SmartThings\Api\SubscriptionApi;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\VirtualDeviceApi;
use ChristianBrown\SmartThings\SmartThings;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformer;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppsTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespaceTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelDriversTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelsTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferencesTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTemperatureTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use ChristianBrown\SmartThings\Transformer\DevicesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\DriversTransformer;
use ChristianBrown\SmartThings\Transformer\DriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformer;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformer;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use ChristianBrown\SmartThings\Transformer\ModesTransformer;
use ChristianBrown\SmartThings\Transformer\ModeTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationsTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationTransformer;
use ChristianBrown\SmartThings\Transformer\RulesTransformer;
use ChristianBrown\SmartThings\Transformer\RuleTransformer;
use ChristianBrown\SmartThings\Transformer\ScenesTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SmartThings::class)]
#[UsesClass(AppApi::class)]
#[UsesClass(CapabilityApi::class)]
#[UsesClass(ChannelApi::class)]
#[UsesClass(DeviceApi::class)]
#[UsesClass(DeviceHealthApi::class)]
#[UsesClass(DeviceHistoryApi::class)]
#[UsesClass(DevicePreferenceDefinitionApi::class)]
#[UsesClass(DevicePreferencesApi::class)]
#[UsesClass(DeviceProfileApi::class)]
#[UsesClass(DeviceStatusApi::class)]
#[UsesClass(DriverApi::class)]
#[UsesClass(HubApi::class)]
#[UsesClass(InstalledAppApi::class)]
#[UsesClass(LocationApi::class)]
#[UsesClass(LocationModeApi::class)]
#[UsesClass(LocationRoomApi::class)]
#[UsesClass(OrganizationApi::class)]
#[UsesClass(PresentationApi::class)]
#[UsesClass(RuleApi::class)]
#[UsesClass(SceneApi::class)]
#[UsesClass(ScheduleApi::class)]
#[UsesClass(SchemaConnectorApi::class)]
#[UsesClass(ServiceApi::class)]
#[UsesClass(SubscriptionApi::class)]
#[UsesClass(VirtualDeviceApi::class)]
#[UsesClass(Token::class)]
#[UsesClass(AppOauthTransformer::class)]
#[UsesClass(AppSettingsTransformer::class)]
#[UsesClass(AppsTransformer::class)]
#[UsesClass(AppTransformer::class)]
#[UsesClass(CapabilitiesTransformer::class)]
#[UsesClass(CapabilityNamespacesTransformer::class)]
#[UsesClass(CapabilityNamespaceTransformer::class)]
#[UsesClass(CapabilityPresentationTransformer::class)]
#[UsesClass(CapabilityTransformer::class)]
#[UsesClass(ChannelDriversTransformer::class)]
#[UsesClass(ChannelDriverTransformer::class)]
#[UsesClass(ChannelsTransformer::class)]
#[UsesClass(ChannelTransformer::class)]
#[UsesClass(DeviceComponentCapabilitiesTransformer::class)]
#[UsesClass(DeviceComponentCapabilityTransformer::class)]
#[UsesClass(DeviceComponentsTransformer::class)]
#[UsesClass(DeviceComponentTransformer::class)]
#[UsesClass(DeviceHealthTransformer::class)]
#[UsesClass(DeviceHistoryEventsTransformer::class)]
#[UsesClass(DeviceHistoryEventTransformer::class)]
#[UsesClass(DevicePreferenceDefinitionsTransformer::class)]
#[UsesClass(DevicePreferenceDefinitionTransformer::class)]
#[UsesClass(DevicePreferencesTransformer::class)]
#[UsesClass(DevicePreferenceTransformer::class)]
#[UsesClass(DeviceProfilesTransformer::class)]
#[UsesClass(DeviceProfileTransformer::class)]
#[UsesClass(DevicesTransformer::class)]
#[UsesClass(DriversTransformer::class)]
#[UsesClass(DriverTransformer::class)]
#[UsesClass(HubCharacteristicsTransformer::class)]
#[UsesClass(HubEnrolledChannelsTransformer::class)]
#[UsesClass(HubEnrolledChannelTransformer::class)]
#[UsesClass(HubInstalledDriversTransformer::class)]
#[UsesClass(HubInstalledDriverTransformer::class)]
#[UsesClass(HubTransformer::class)]
#[UsesClass(DeviceStatusBatteryBatteryTransformer::class)]
#[UsesClass(DeviceStatusBatteryTransformer::class)]
#[UsesClass(DeviceStatusRelativeHumidityMeasurementHumidityTransformer::class)]
#[UsesClass(DeviceStatusRelativeHumidityMeasurementTransformer::class)]
#[UsesClass(DeviceStatusTemperatureMeasurementTemperatureTransformer::class)]
#[UsesClass(DeviceStatusTemperatureMeasurementTransformer::class)]
#[UsesClass(DeviceStatusTransformer::class)]
#[UsesClass(DeviceTransformer::class)]
#[UsesClass(InstalledAppConfigsTransformer::class)]
#[UsesClass(InstalledAppConfigTransformer::class)]
#[UsesClass(InstalledAppsTransformer::class)]
#[UsesClass(InstalledAppTransformer::class)]
#[UsesClass(LocationsTransformer::class)]
#[UsesClass(LocationTransformer::class)]
#[UsesClass(LocationRoomsTransformer::class)]
#[UsesClass(LocationRoomTransformer::class)]
#[UsesClass(ModesTransformer::class)]
#[UsesClass(ModeTransformer::class)]
#[UsesClass(OrganizationsTransformer::class)]
#[UsesClass(OrganizationTransformer::class)]
#[UsesClass(PresentationTransformer::class)]
#[UsesClass(RulesTransformer::class)]
#[UsesClass(RuleTransformer::class)]
#[UsesClass(ScenesTransformer::class)]
#[UsesClass(SceneTransformer::class)]
#[UsesClass(SchedulesTransformer::class)]
#[UsesClass(ScheduleTransformer::class)]
#[UsesClass(SchemaAppsTransformer::class)]
#[UsesClass(SchemaAppTransformer::class)]
#[UsesClass(SchemaPageTransformer::class)]
#[UsesClass(InstalledSchemaAppsTransformer::class)]
#[UsesClass(InstalledSchemaAppTransformer::class)]
#[UsesClass(ServiceCapabilityDataTransformer::class)]
#[UsesClass(ServiceCapabilityNamesTransformer::class)]
#[UsesClass(ServiceLocationInfoSubscriptionsTransformer::class)]
#[UsesClass(ServiceLocationInfoSubscriptionTransformer::class)]
#[UsesClass(ServiceLocationInfoTransformer::class)]
#[UsesClass(ServiceMeasurementsTransformer::class)]
#[UsesClass(ServiceMeasurementTransformer::class)]
#[UsesClass(SubscriptionsTransformer::class)]
#[UsesClass(SubscriptionTransformer::class)]
final class SmartThingsTest extends TestCase
{
    public function testGetAppApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(AppApi::class, $smartThings->getAppApi());
    }

    public function testGetCapabilityApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(CapabilityApi::class, $smartThings->getCapabilityApi());
    }

    public function testGetChannelApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(ChannelApi::class, $smartThings->getChannelApi());
    }

    public function testGetDeviceApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceApi::class, $smartThings->getDeviceApi());
    }

    public function testGetDeviceHealthApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceHealthApi::class, $smartThings->getDeviceHealthApi());
    }

    public function testGetDeviceHistoryApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceHistoryApi::class, $smartThings->getDeviceHistoryApi());
    }

    public function testGetDevicePreferenceDefinitionApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DevicePreferenceDefinitionApi::class, $smartThings->getDevicePreferenceDefinitionApi());
    }

    public function testGetDevicePreferencesApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DevicePreferencesApi::class, $smartThings->getDevicePreferencesApi());
    }

    public function testGetDeviceProfileApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceProfileApi::class, $smartThings->getDeviceProfileApi());
    }

    public function testGetDeviceStatusApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceStatusApi::class, $smartThings->getDeviceStatusApi());
    }

    public function testGetDriverApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DriverApi::class, $smartThings->getDriverApi());
    }

    public function testGetHubApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(HubApi::class, $smartThings->getHubApi());
    }

    public function testGetInstalledAppApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(InstalledAppApi::class, $smartThings->getInstalledAppApi());
    }

    public function testGetLocationApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(LocationApi::class, $smartThings->getLocationApi());
    }

    public function testGetLocationModeApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(LocationModeApi::class, $smartThings->getLocationModeApi());
    }

    public function testGetLocationRoomApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(LocationRoomApi::class, $smartThings->getLocationRoomApi());
    }

    public function testGetOrganizationApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(OrganizationApi::class, $smartThings->getOrganizationApi());
    }

    public function testGetPresentationApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(PresentationApi::class, $smartThings->getPresentationApi());
    }

    public function testGetRuleApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(RuleApi::class, $smartThings->getRuleApi());
    }

    public function testGetSceneApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(SceneApi::class, $smartThings->getSceneApi());
    }

    public function testGetScheduleApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(ScheduleApi::class, $smartThings->getScheduleApi());
    }

    public function testGetSchemaConnectorApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(SchemaConnectorApi::class, $smartThings->getSchemaConnectorApi());
    }

    public function testGetServiceApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(ServiceApi::class, $smartThings->getServiceApi());
    }

    public function testGetSubscriptionApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(SubscriptionApi::class, $smartThings->getSubscriptionApi());
    }

    public function testGetVirtualDeviceApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(VirtualDeviceApi::class, $smartThings->getVirtualDeviceApi());
    }
}
