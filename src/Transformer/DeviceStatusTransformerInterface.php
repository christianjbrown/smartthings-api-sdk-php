<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatusInterface;

interface DeviceStatusTransformerInterface
{
    public const KEY_BATTERY = 'battery';
    public const KEY_RELATIVE_HUMIDITY_MEASUREMENT = 'relativeHumidityMeasurement';
    public const KEY_TEMPERATURE_MEASUREMENT = 'temperatureMeasurement';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusInterface;
}
