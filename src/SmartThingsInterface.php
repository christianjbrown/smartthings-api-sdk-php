<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHistoryApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferencesApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
use ChristianBrown\SmartThings\Api\OrganizationApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;
use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\SceneApiInterface;
use ChristianBrown\SmartThings\Api\ScheduleApiInterface;
use ChristianBrown\SmartThings\Api\SubscriptionApiInterface;
use ChristianBrown\SmartThings\Api\VirtualDeviceApiInterface;

interface SmartThingsInterface
{
    public const string SERVICE_API_CLIENT = 'smartthings.api_client';
    public const string SERVICE_APP_API = 'smartthings.api.app_api';
    public const string SERVICE_APP_OAUTH_TRANSFORMER = 'smartthings.transformer.app_oauth_transformer';
    public const string SERVICE_APP_SETTINGS_TRANSFORMER = 'smartthings.transformer.app_settings_transformer';
    public const string SERVICE_APP_TRANSFORMER = 'smartthings.transformer.app_transformer';
    public const string SERVICE_APPS_TRANSFORMER = 'smartthings.transformer.apps_transformer';
    public const string SERVICE_CAPABILITIES_TRANSFORMER = 'smartthings.transformer.capabilities_transformer';
    public const string SERVICE_CAPABILITY_API = 'smartthings.api.capability_api';
    public const string SERVICE_CAPABILITY_NAMESPACE_TRANSFORMER = 'smartthings.transformer.capability_namespace_transformer';
    public const string SERVICE_CAPABILITY_NAMESPACES_TRANSFORMER = 'smartthings.transformer.capability_namespaces_transformer';
    public const string SERVICE_CAPABILITY_PRESENTATION_TRANSFORMER = 'smartthings.transformer.capability_presentation_transformer';
    public const string SERVICE_CAPABILITY_TRANSFORMER = 'smartthings.transformer.capability_transformer';
    public const string SERVICE_DEVICE_API = 'smartthings.api.device_api';
    public const string SERVICE_DEVICE_COMPONENT_CAPABILITIES_TRANSFORMER = 'smartthings.transformer.device_component_capabilities_transformer';
    public const string SERVICE_DEVICE_COMPONENT_CAPABILITY_TRANSFORMER = 'smartthings.transformer.device_component_capability_transformer';
    public const string SERVICE_DEVICE_COMPONENT_TRANSFORMER = 'smartthings.transformer.device_component_transformer';
    public const string SERVICE_DEVICE_COMPONENTS_TRANSFORMER = 'smartthings.transformer.device_components_transformer';
    public const string SERVICE_DEVICE_HEALTH_API = 'smartthings.api.device_health_api';
    public const string SERVICE_DEVICE_HEALTH_TRANSFORMER = 'smartthings.transformer.device_health_transformer';
    public const string SERVICE_DEVICE_HISTORY_API = 'smartthings.api.device_history_api';
    public const string SERVICE_DEVICE_HISTORY_EVENT_TRANSFORMER = 'smartthings.transformer.device_history_event_transformer';
    public const string SERVICE_DEVICE_HISTORY_EVENTS_TRANSFORMER = 'smartthings.transformer.device_history_events_transformer';
    public const string SERVICE_DEVICE_PREFERENCE_TRANSFORMER = 'smartthings.transformer.device_preference_transformer';
    public const string SERVICE_DEVICE_PREFERENCES_API = 'smartthings.api.device_preferences_api';
    public const string SERVICE_DEVICE_PREFERENCES_TRANSFORMER = 'smartthings.transformer.device_preferences_transformer';
    public const string SERVICE_DEVICE_PROFILE_API = 'smartthings.api.device_profile_api';
    public const string SERVICE_DEVICE_PROFILE_TRANSFORMER = 'smartthings.transformer.device_profile_transformer';
    public const string SERVICE_DEVICE_PROFILES_TRANSFORMER = 'smartthings.transformer.device_profiles_transformer';
    public const string SERVICE_DEVICE_STATUS_API = 'smartthings.api.device_status_api';
    public const string SERVICE_DEVICE_STATUS_BATTERY_BATTERY_TRANSFORMER = 'smartthings.transformer.device_status_battery_battery_transformer';
    public const string SERVICE_DEVICE_STATUS_BATTERY_TRANSFORMER = 'smartthings.transformer.device_status_battery_transformer';
    public const string SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_HUMIDITY_TRANSFORMER = 'smartthings.transformer.device_status_relative_humidity_measurement_humidity_transformer';
    public const string SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_TRANSFORMER = 'smartthings.transformer.device_status_relative_humidity_measurement_transformer';
    public const string SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TEMPERATURE_TRANSFORMER = 'smartthings.transformer.device_status_temperature_measurement_temperature_transformer';
    public const string SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TRANSFORMER = 'smartthings.transformer.device_status_temperature_measurement_transformer';
    public const string SERVICE_DEVICE_STATUS_TRANSFORMER = 'smartthings.transformer.device_status_transformer';
    public const string SERVICE_DEVICE_TRANSFORMER = 'smartthings.transformer.device_transformer';
    public const string SERVICE_DEVICES_TRANSFORMER = 'smartthings.transformer.devices_transformer';
    public const string SERVICE_INSTALLED_APP_API = 'smartthings.api.installed_app_api';
    public const string SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER = 'smartthings.transformer.installed_app_config_transformer';
    public const string SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER = 'smartthings.transformer.installed_app_configs_transformer';
    public const string SERVICE_INSTALLED_APP_TRANSFORMER = 'smartthings.transformer.installed_app_transformer';
    public const string SERVICE_INSTALLED_APPS_TRANSFORMER = 'smartthings.transformer.installed_apps_transformer';
    public const string SERVICE_JSON_API_REQUEST_SENDER = 'smartthings.json_api_request_sender';
    public const string SERVICE_LOCATION_API = 'smartthings.api.location_api';
    public const string SERVICE_LOCATION_MODE_API = 'smartthings.api.location_mode_api';
    public const string SERVICE_LOCATION_ROOM_API = 'smartthings.api.location_room_api';
    public const string SERVICE_LOCATION_ROOM_TRANSFORMER = 'smartthings.transformer.location_room_transformer';
    public const string SERVICE_LOCATION_ROOMS_TRANSFORMER = 'smartthings.transformer.location_rooms_transformer';
    public const string SERVICE_LOCATION_TRANSFORMER = 'smartthings.transformer.location_transformer';
    public const string SERVICE_LOCATIONS_TRANSFORMER = 'smartthings.transformer.locations_transformer';
    public const string SERVICE_MODE_TRANSFORMER = 'smartthings.transformer.mode_transformer';
    public const string SERVICE_MODES_TRANSFORMER = 'smartthings.transformer.modes_transformer';
    public const string SERVICE_ORGANIZATION_API = 'smartthings.api.organization_api';
    public const string SERVICE_ORGANIZATION_TRANSFORMER = 'smartthings.transformer.organization_transformer';
    public const string SERVICE_ORGANIZATIONS_TRANSFORMER = 'smartthings.transformer.organizations_transformer';
    public const string SERVICE_PRESENTATION_API = 'smartthings.api.presentation_api';
    public const string SERVICE_PRESENTATION_TRANSFORMER = 'smartthings.transformer.presentation_transformer';
    public const string SERVICE_RULE_API = 'smartthings.api.rule_api';
    public const string SERVICE_RULE_TRANSFORMER = 'smartthings.transformer.rule_transformer';
    public const string SERVICE_RULES_TRANSFORMER = 'smartthings.transformer.rules_transformer';
    public const string SERVICE_SCENE_API = 'smartthings.api.scene_api';
    public const string SERVICE_SCENE_TRANSFORMER = 'smartthings.transformer.scene_transformer';
    public const string SERVICE_SCENES_TRANSFORMER = 'smartthings.transformer.scenes_transformer';
    public const string SERVICE_SCHEDULE_API = 'smartthings.api.schedule_api';
    public const string SERVICE_SCHEDULE_TRANSFORMER = 'smartthings.transformer.schedule_transformer';
    public const string SERVICE_SCHEDULES_TRANSFORMER = 'smartthings.transformer.schedules_transformer';
    public const string SERVICE_SUBSCRIPTION_API = 'smartthings.api.subscription_api';
    public const string SERVICE_SUBSCRIPTION_TRANSFORMER = 'smartthings.transformer.subscription_transformer';
    public const string SERVICE_SUBSCRIPTIONS_TRANSFORMER = 'smartthings.transformer.subscriptions_transformer';
    public const string SERVICE_VIRTUAL_DEVICE_API = 'smartthings.api.virtual_device_api';

    public function getAppApi(): AppApiInterface;

    public function getCapabilityApi(): CapabilityApiInterface;

    public function getDeviceApi(): DeviceApiInterface;

    public function getDeviceHealthApi(): DeviceHealthApiInterface;

    public function getDeviceHistoryApi(): DeviceHistoryApiInterface;

    public function getDevicePreferencesApi(): DevicePreferencesApiInterface;

    public function getDeviceProfileApi(): DeviceProfileApiInterface;

    public function getDeviceStatusApi(): DeviceStatusApiInterface;

    public function getInstalledAppApi(): InstalledAppApiInterface;

    public function getLocationApi(): LocationApiInterface;

    public function getLocationModeApi(): LocationModeApiInterface;

    public function getLocationRoomApi(): LocationRoomApiInterface;

    public function getOrganizationApi(): OrganizationApiInterface;

    public function getPresentationApi(): PresentationApiInterface;

    public function getRuleApi(): RuleApiInterface;

    public function getSceneApi(): SceneApiInterface;

    public function getScheduleApi(): ScheduleApiInterface;

    public function getSubscriptionApi(): SubscriptionApiInterface;

    public function getVirtualDeviceApi(): VirtualDeviceApiInterface;
}
