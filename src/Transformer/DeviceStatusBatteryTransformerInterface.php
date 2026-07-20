<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatusBatteryInterface;

interface DeviceStatusBatteryTransformerInterface
{
    public const string KEY_BATTERY = 'battery';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ?DeviceStatusBatteryInterface;
}
