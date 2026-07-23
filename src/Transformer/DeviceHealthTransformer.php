<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHealth;
use ChristianBrown\SmartThings\Model\DeviceHealthInterface;

use function is_string;
use function sprintf;
use function strtotime;

final class DeviceHealthTransformer implements DeviceHealthTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceHealthInterface
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DEVICE_ID));
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DEVICE_ID));
        }
        $health = new DeviceHealth($data[self::KEY_DEVICE_ID]);

        self::applyLastUpdatedDate($health, $data);
        self::applyState($health, $data);

        return $health;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastUpdatedDate(DeviceHealth $health, array $data): void
    {
        if (empty($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_LAST_UPDATED_DATE]);
        if (false === $timestamp) {
            return;
        }
        $health->setLastUpdatedDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyState(DeviceHealth $health, array $data): void
    {
        if (empty($data[self::KEY_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE])) {
            return;
        }
        $health->setState($data[self::KEY_STATE]);
    }
}
