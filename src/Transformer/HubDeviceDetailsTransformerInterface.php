<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsInterface;

interface HubDeviceDetailsTransformerInterface
{
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_FIRMWARE_VERSION = 'firmwareVersion';
    public const string KEY_HUB_DATA = 'hubData';
    public const string KEY_HUB_DRIVERS = 'hubDrivers';
    public const string KEY_HUB_EUI = 'hubEui';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsInterface;
}
