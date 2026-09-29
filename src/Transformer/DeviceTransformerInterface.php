<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceInterface;

interface DeviceTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_HEALTH_STATE, self::KEY_PROFILE, self::KEY_APP, self::KEY_BLE_D2_D, self::KEY_DTH, self::KEY_LAN, self::KEY_ZIGBEE, self::KEY_ZWAVE, self::KEY_MATTER, self::KEY_HUB, self::KEY_EDGE_CHILD, self::KEY_IR, self::KEY_IR_OCF, self::KEY_OCF, self::KEY_VIPER, self::KEY_GROUP, self::KEY_VIRTUAL, self::KEY_MQTT, self::KEY_INDOOR_MAP, self::KEY_RELATIONSHIPS];
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_APP = 'app';
    public const string KEY_BLE = 'ble';
    public const string KEY_BLE_D2_D = 'bleD2D';
    public const string KEY_BRAND_ID = 'brandId';
    public const string KEY_CHILD_DEVICES = 'childDevices';
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_CREATE_TIME = 'createTime';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_DEVICE_MANUFACTURER_CODE = 'deviceManufacturerCode';
    public const string KEY_DEVICE_NETWORK_TYPE = 'deviceNetworkType';
    public const string KEY_DEVICE_TYPE_ID = 'deviceTypeId';
    public const string KEY_DEVICE_TYPE_NAME = 'deviceTypeName';
    public const string KEY_DTH = 'dth';
    public const string KEY_EDGE_CHILD = 'edgeChild';
    public const string KEY_EXECUTION_CONTEXT = 'executionContext';
    public const string KEY_GROUP = 'group';
    public const string KEY_HEALTH_STATE = 'healthState';
    public const string KEY_HUB = 'hub';
    public const string KEY_INDOOR_MAP = 'indoorMap';
    public const string KEY_IR = 'ir';
    public const string KEY_IR_OCF = 'irOcf';
    public const string KEY_LABEL = 'label';
    public const string KEY_LAN = 'lan';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_MATTER = 'matter';
    public const string KEY_MQTT = 'mqtt';
    public const string KEY_NAME = 'name';
    public const string KEY_OCF = 'ocf';
    public const string KEY_OWNER_ID = 'ownerId';
    public const string KEY_PARENT_DEVICE_ID = 'parentDeviceId';
    public const string KEY_PRESENTATION_ID = 'presentationId';
    public const string KEY_PRODUCT_ID = 'productId';
    public const string KEY_PROFILE = 'profile';
    public const string KEY_RELATIONSHIPS = 'relationships';
    public const string KEY_RESTRICTION_TIER = 'restrictionTier';
    public const string KEY_ROOM_ID = 'roomId';
    public const string KEY_TYPE = 'type';
    public const string KEY_VIPER = 'viper';
    public const string KEY_VIRTUAL = 'virtual';
    public const string KEY_ZIGBEE = 'zigbee';
    public const string KEY_ZWAVE = 'zwave';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceInterface;
}
