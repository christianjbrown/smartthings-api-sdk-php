<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidity;
use ChristianBrown\SmartThings\Model\DeviceStatusRelativeHumidityMeasurementHumidityInterface;

use function is_float;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class DeviceStatusRelativeHumidityMeasurementHumidityTransformer implements DeviceStatusRelativeHumidityMeasurementHumidityTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusRelativeHumidityMeasurementHumidityInterface
    {
        if (empty($data[self::KEY_TIMESTAMP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIMESTAMP));
        }
        if (!is_string($data[self::KEY_TIMESTAMP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIMESTAMP));
        }
        $timestamp = strtotime($data[self::KEY_TIMESTAMP]);
        if (false === $timestamp) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_DATA_TIMESTAMP, $data[self::KEY_TIMESTAMP]));
        }

        if (empty($data[self::KEY_UNIT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_UNIT));
        }
        if (!is_string($data[self::KEY_UNIT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_UNIT));
        }
        $unit = $data[self::KEY_UNIT];

        if (!isset($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_FLOAT_SPRINTF, self::KEY_VALUE));
        }
        if (!is_int($data[self::KEY_VALUE]) && !is_float($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_FLOAT_SPRINTF, self::KEY_VALUE));
        }
        $value = (float) $data[self::KEY_VALUE];

        $humidity = new DeviceStatusRelativeHumidityMeasurementHumidity($timestamp, $unit, $value);

        return $humidity;
    }
}
