<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

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
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Api\VirtualDeviceApi;
use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ApiClientRegistrar implements ServiceRegistrarInterface
{
    private TokenInterface $token;

    public function __construct(TokenInterface $token)
    {
        $this->token = $token;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_APP_API, AppApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_APPS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_OAUTH_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_SETTINGS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_API, CapabilityApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CAPABILITY_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CAPABILITIES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CAPABILITY_NAMESPACES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CAPABILITY_PRESENTATION_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALE_REFERENCES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALIZATION_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CHANNEL_API, ChannelApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CHANNEL_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CHANNELS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_CHANNEL_DRIVERS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DRIVER_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_API, DeviceApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICES_TRANSFORMER),
                    $this->token,
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_COMMAND_SERIALIZER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_COMMAND_RESULTS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_INSTALL_REQUEST_SERIALIZER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_UPDATE_DEVICE_REQUEST_SERIALIZER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_EVENT_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HEALTH_API, DeviceHealthApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_HEALTH_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HISTORY_API, DeviceHistoryApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_HISTORY_EVENTS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_API, DevicePreferenceDefinitionApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITIONS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALE_REFERENCES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALIZATION_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_API, DevicePreferencesApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_API, DeviceProfileApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALE_REFERENCES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALIZATION_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_API, DeviceStatusApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DRIVER_API, DriverApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DRIVER_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DRIVERS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_HUB_API, HubApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_CHARACTERISTICS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVER_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVERS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_ENROLLED_CHANNELS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_API, InstalledAppApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APPS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCATION_API, LocationApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATIONS_TRANSFORMER),
                    $this->token,
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_CREATE_REQUEST_SERIALIZER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_UPDATE_REQUEST_SERIALIZER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_PATCH_REQUEST_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCATION_MODE_API, LocationModeApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_MODE_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_MODES_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOM_API, LocationRoomApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOMS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICES_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ORGANIZATION_API, OrganizationApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_ORGANIZATION_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_ORGANIZATIONS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_API, PresentationApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_PRESENTATION_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RULE_API, RuleApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_RULE_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_RULES_TRANSFORMER),
                    $this->token,
                    $container->getDefinition(SmartThingsInterface::SERVICE_RULE_EXECUTION_RESULT_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_RULE_REQUEST_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCENE_API, SceneApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCENE_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCENES_TRANSFORMER),
                    $this->token,
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCENE_EXECUTION_RESULT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEDULE_API, ScheduleApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEDULE_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEDULES_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_CONNECTOR_API, SchemaConnectorApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEMA_APP_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEMA_APPS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APPS_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEMA_PAGE_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_API, ServiceApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_NAMES_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTION_API, SubscriptionApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SUBSCRIPTION_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_SUBSCRIPTIONS_TRANSFORMER),
                    $this->token,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_API, VirtualDeviceApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICES_TRANSFORMER),
                    $this->token,
                ]
            );
    }
}
