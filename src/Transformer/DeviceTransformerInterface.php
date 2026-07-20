<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceInterface;

interface DeviceTransformerInterface
{
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_LABEL = 'label';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NAME = 'name';
    public const string KEY_ROOM_ID = 'roomId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceInterface;
}
