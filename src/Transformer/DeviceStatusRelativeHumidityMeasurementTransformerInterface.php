<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementInterface;

interface DeviceStatusRelativeHumidityMeasurementTransformerInterface
{
    public const string KEY_HUMIDITY = 'humidity';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusRelativeHumidityMeasurementInterface;
}
