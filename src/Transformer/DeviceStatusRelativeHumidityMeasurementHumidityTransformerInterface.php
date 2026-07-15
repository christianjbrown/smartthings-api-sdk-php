<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidityInterface;

interface DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface
{
    public const KEY_TIMESTAMP = 'timestamp';
    public const KEY_UNIT = 'unit';
    public const KEY_VALUE = 'value';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const UNEXPECTED_DATA_TIMESTAMP = '%s not a valid timestamp';
    public const UNEXPECTED_FLOAT_SPRINTF = '%s not set or not a floating point number';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusRelativeHumidityMeasurementHumidityInterface;
}
