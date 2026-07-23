<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceHealthInterface;

interface DeviceHealthTransformerInterface
{
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_LAST_UPDATED_DATE = 'lastUpdatedDate';
    public const string KEY_STATE = 'state';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceHealthInterface;
}
