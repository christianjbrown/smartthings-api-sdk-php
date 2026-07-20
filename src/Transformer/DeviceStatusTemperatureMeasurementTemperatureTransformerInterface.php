<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatusTemperatureMeasurementTemperatureInterface;

interface DeviceStatusTemperatureMeasurementTemperatureTransformerInterface
{
    public const string KEY_TIMESTAMP = 'timestamp';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_DATA_TIMESTAMP = '%s not a valid timestamp';
    public const string UNEXPECTED_FLOAT_SPRINTF = '%s not set or not a floating point number';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusTemperatureMeasurementTemperatureInterface;
}
