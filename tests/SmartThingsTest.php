<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests;

use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\ChannelApiInterface;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHistoryApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferencesApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\DriverApiInterface;
use ChristianBrown\SmartThings\Api\HubApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
use ChristianBrown\SmartThings\Api\OrganizationApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;
use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\SceneApiInterface;
use ChristianBrown\SmartThings\Api\ScheduleApiInterface;
use ChristianBrown\SmartThings\Api\SchemaAppInviteApiInterface;
use ChristianBrown\SmartThings\Api\SchemaAppOwnerApiInterface;
use ChristianBrown\SmartThings\Api\SchemaConnectorApiInterface;
use ChristianBrown\SmartThings\Api\ServiceApiInterface;
use ChristianBrown\SmartThings\Api\SubscriptionApiInterface;
use ChristianBrown\SmartThings\Api\TextToSpeechApiInterface;
use ChristianBrown\SmartThings\Api\VirtualDeviceApiInterface;
use ChristianBrown\SmartThings\SmartThings;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ErrorResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

#[CoversClass(SmartThings::class)]
final class SmartThingsTest extends TestCase
{
    /**
     * @param string       $getter    the facade method under test
     * @param string       $serviceId the container id it reads
     * @param class-string $interface the interface the getter returns
     */
    #[DataProvider('provideGetterReturnsTheServiceFromTheContainerCases')]
    public function testGetterReturnsTheServiceFromTheContainer(string $getter, string $serviceId, string $interface): void
    {
        $service = self::createStub($interface);
        $container = $this->createMock(ContainerInterface::class);
        $container->expects(self::once())
            ->method('get')
            ->with($serviceId)
            ->willReturn($service);

        $smartThings = new SmartThings($container);

        self::assertSame($service, $smartThings->{$getter}());
    }

    /**
     * @return iterable<string, array{string, string, class-string}>
     */
    public static function provideGetterReturnsTheServiceFromTheContainerCases(): iterable
    {
        yield 'getAppApi' => ['getAppApi', SmartThingsInterface::SERVICE_APP_API, AppApiInterface::class];

        yield 'getCapabilityApi' => ['getCapabilityApi', SmartThingsInterface::SERVICE_CAPABILITY_API, CapabilityApiInterface::class];

        yield 'getChannelApi' => ['getChannelApi', SmartThingsInterface::SERVICE_CHANNEL_API, ChannelApiInterface::class];

        yield 'getDeviceApi' => ['getDeviceApi', SmartThingsInterface::SERVICE_DEVICE_API, DeviceApiInterface::class];

        yield 'getDeviceHealthApi' => ['getDeviceHealthApi', SmartThingsInterface::SERVICE_DEVICE_HEALTH_API, DeviceHealthApiInterface::class];

        yield 'getDeviceHistoryApi' => ['getDeviceHistoryApi', SmartThingsInterface::SERVICE_DEVICE_HISTORY_API, DeviceHistoryApiInterface::class];

        yield 'getDevicePreferenceDefinitionApi' => ['getDevicePreferenceDefinitionApi', SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_API, DevicePreferenceDefinitionApiInterface::class];

        yield 'getDevicePreferencesApi' => ['getDevicePreferencesApi', SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_API, DevicePreferencesApiInterface::class];

        yield 'getDeviceProfileApi' => ['getDeviceProfileApi', SmartThingsInterface::SERVICE_DEVICE_PROFILE_API, DeviceProfileApiInterface::class];

        yield 'getDeviceStatusApi' => ['getDeviceStatusApi', SmartThingsInterface::SERVICE_DEVICE_STATUS_API, DeviceStatusApiInterface::class];

        yield 'getDriverApi' => ['getDriverApi', SmartThingsInterface::SERVICE_DRIVER_API, DriverApiInterface::class];

        yield 'getErrorResponseTransformer' => ['getErrorResponseTransformer', SmartThingsInterface::SERVICE_ERROR_RESPONSE_TRANSFORMER, ErrorResponseTransformerInterface::class];

        yield 'getHubApi' => ['getHubApi', SmartThingsInterface::SERVICE_HUB_API, HubApiInterface::class];

        yield 'getInstalledAppApi' => ['getInstalledAppApi', SmartThingsInterface::SERVICE_INSTALLED_APP_API, InstalledAppApiInterface::class];

        yield 'getLocationApi' => ['getLocationApi', SmartThingsInterface::SERVICE_LOCATION_API, LocationApiInterface::class];

        yield 'getLocationModeApi' => ['getLocationModeApi', SmartThingsInterface::SERVICE_LOCATION_MODE_API, LocationModeApiInterface::class];

        yield 'getLocationRoomApi' => ['getLocationRoomApi', SmartThingsInterface::SERVICE_LOCATION_ROOM_API, LocationRoomApiInterface::class];

        yield 'getOrganizationApi' => ['getOrganizationApi', SmartThingsInterface::SERVICE_ORGANIZATION_API, OrganizationApiInterface::class];

        yield 'getPresentationApi' => ['getPresentationApi', SmartThingsInterface::SERVICE_PRESENTATION_API, PresentationApiInterface::class];

        yield 'getRuleApi' => ['getRuleApi', SmartThingsInterface::SERVICE_RULE_API, RuleApiInterface::class];

        yield 'getSceneApi' => ['getSceneApi', SmartThingsInterface::SERVICE_SCENE_API, SceneApiInterface::class];

        yield 'getScheduleApi' => ['getScheduleApi', SmartThingsInterface::SERVICE_SCHEDULE_API, ScheduleApiInterface::class];

        yield 'getSchemaAppInviteApi' => ['getSchemaAppInviteApi', SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_API, SchemaAppInviteApiInterface::class];

        yield 'getSchemaAppOwnerApi' => ['getSchemaAppOwnerApi', SmartThingsInterface::SERVICE_SCHEMA_APP_OWNER_API, SchemaAppOwnerApiInterface::class];

        yield 'getSchemaConnectorApi' => ['getSchemaConnectorApi', SmartThingsInterface::SERVICE_SCHEMA_CONNECTOR_API, SchemaConnectorApiInterface::class];

        yield 'getServiceApi' => ['getServiceApi', SmartThingsInterface::SERVICE_SERVICE_API, ServiceApiInterface::class];

        yield 'getSubscriptionApi' => ['getSubscriptionApi', SmartThingsInterface::SERVICE_SUBSCRIPTION_API, SubscriptionApiInterface::class];

        yield 'getTextToSpeechApi' => ['getTextToSpeechApi', SmartThingsInterface::SERVICE_TEXT_TO_SPEECH_API, TextToSpeechApiInterface::class];

        yield 'getVirtualDeviceApi' => ['getVirtualDeviceApi', SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_API, VirtualDeviceApiInterface::class];
    }
}
