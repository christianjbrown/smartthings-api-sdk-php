<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceDetailsInterface;

interface DeviceDetailsTransformerInterface
{
    public const string KEY_APP = 'app';
    public const string KEY_BLE_D2_D = 'bleD2D';
    public const string KEY_DTH = 'dth';
    public const string KEY_EDGE_CHILD = 'edgeChild';
    public const string KEY_GROUP = 'group';
    public const string KEY_HEALTH_STATE = 'healthState';
    public const string KEY_HUB = 'hub';
    public const string KEY_INDOOR_MAP = 'indoorMap';
    public const string KEY_IR = 'ir';
    public const string KEY_IR_OCF = 'irOcf';
    public const string KEY_LAN = 'lan';
    public const string KEY_MATTER = 'matter';
    public const string KEY_MQTT = 'mqtt';
    public const string KEY_OCF = 'ocf';
    public const string KEY_PROFILE = 'profile';
    public const string KEY_RELATIONSHIPS = 'relationships';
    public const string KEY_VIPER = 'viper';
    public const string KEY_VIRTUAL = 'virtual';
    public const string KEY_ZIGBEE = 'zigbee';
    public const string KEY_ZWAVE = 'zwave';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceDetailsInterface;
}
