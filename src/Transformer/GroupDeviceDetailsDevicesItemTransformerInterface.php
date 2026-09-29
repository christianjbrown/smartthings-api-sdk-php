<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemInterface;

interface GroupDeviceDetailsDevicesItemTransformerInterface
{
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GroupDeviceDetailsDevicesItemInterface;
}
