<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryBattery;
use ChristianBrown\SmartThings\Model\DeviceStatusBatteryBatteryInterface;

use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class DeviceStatusBatteryBatteryTransformer implements DeviceStatusBatteryBatteryTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusBatteryBatteryInterface
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
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INT_SPRINTF, self::KEY_VALUE));
        }
        if (!is_int($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INT_SPRINTF, self::KEY_VALUE));
        }
        $value = $data[self::KEY_VALUE];

        $battery = new DeviceStatusBatteryBattery($timestamp, $unit, $value);

        return $battery;
    }
}
