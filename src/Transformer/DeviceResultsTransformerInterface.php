<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceResultsInterface;

interface DeviceResultsTransformerInterface
{
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_NAME = 'name';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceResultsInterface;
}
