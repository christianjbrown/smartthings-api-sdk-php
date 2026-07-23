<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;

interface DeviceHistoryEventTransformerInterface
{
    public const string KEY_ATTRIBUTE = 'attribute';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_EPOCH = 'epoch';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceHistoryEventInterface;
}
