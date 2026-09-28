<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ApiClientRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ApiClientRegistrar::class)]
final class ApiClientRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        $container->register(SmartThingsInterface::SERVICE_APPS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_APP_OAUTH_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_APP_SETTINGS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_APP_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITIES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_NAMESPACES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_PRESENTATION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CHANNELS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CHANNEL_DRIVERS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_CHANNEL_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_COMMAND_SERIALIZER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_COMMAND_RESULTS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_EVENT_SERIALIZER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HEALTH_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_INSTALL_REQUEST_SERIALIZER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HISTORY_EVENTS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITIONS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DRIVERS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_DRIVER_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_CHARACTERISTICS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_ENROLLED_CHANNELS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVERS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVER_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APPS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APPS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_LOCALE_REFERENCES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_LOCALIZATION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATIONS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOMS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_MODES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_MODE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_ORGANIZATIONS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_ORGANIZATION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_RULES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_RULE_EXECUTION_RESULT_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_RULE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCENES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCENE_EXECUTION_RESULT_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCENE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEDULES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEDULE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APPS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_PAGE_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_NAMES_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTIONS_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTION_TRANSFORMER, stdClass::class);
        $container->register(SmartThingsInterface::SERVICE_UPDATE_DEVICE_REQUEST_SERIALIZER, stdClass::class);

        $token = self::createStub(TokenInterface::class);

        (new ApiClientRegistrar($token))->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_APP_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CHANNEL_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_HEALTH_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_HISTORY_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DRIVER_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_HUB_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_MODE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOM_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ORGANIZATION_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PRESENTATION_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_RULE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SCENE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SCHEDULE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SCHEMA_CONNECTOR_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SERVICE_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SUBSCRIPTION_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_API));
    }
}
