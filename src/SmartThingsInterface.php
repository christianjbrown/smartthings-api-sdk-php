<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;

interface SmartThingsInterface
{
    public const string SERVICE_API_CLIENT = 'smartthings.api_client';
    public const string SERVICE_DEVICE_API = 'smartthings.api.device_api';
    public const string SERVICE_DEVICE_COMPONENT_CAPABILITIES_TRANSFORMER = 'smartthings.transformer.device_component_capabilities_transformer';
    public const string SERVICE_DEVICE_COMPONENT_CAPABILITY_TRANSFORMER = 'smartthings.transformer.device_component_capability_transformer';
    public const string SERVICE_DEVICE_COMPONENT_TRANSFORMER = 'smartthings.transformer.device_component_transformer';
    public const string SERVICE_DEVICE_COMPONENTS_TRANSFORMER = 'smartthings.transformer.device_components_transformer';
    public const string SERVICE_DEVICE_HEALTH_API = 'smartthings.api.device_health_api';
    public const string SERVICE_DEVICE_HEALTH_TRANSFORMER = 'smartthings.transformer.device_health_transformer';
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

    public function getDeviceApi(): DeviceApiInterface;

    public function getDeviceHealthApi(): DeviceHealthApiInterface;

    public function getDeviceStatusApi(): DeviceStatusApiInterface;

    public function getLocationApi(): LocationApiInterface;

    public function getLocationModeApi(): LocationModeApiInterface;

    public function getLocationRoomApi(): LocationRoomApiInterface;
}
