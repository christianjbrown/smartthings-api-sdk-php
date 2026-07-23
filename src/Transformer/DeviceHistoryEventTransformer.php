<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHistoryEvent;
use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;

use function is_int;
use function is_string;
use function sprintf;

final class DeviceHistoryEventTransformer implements DeviceHistoryEventTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceHistoryEventInterface
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DEVICE_ID));
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DEVICE_ID));
        }
        $event = new DeviceHistoryEvent($data[self::KEY_DEVICE_ID]);

        self::applyAttribute($event, $data);
        self::applyCapability($event, $data);
        self::applyComponent($event, $data);
        self::applyEpoch($event, $data);
        self::applyLocationId($event, $data);
        self::applyValue($event, $data);

        return $event;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAttribute(DeviceHistoryEvent $event, array $data): void
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        $event->setAttribute($data[self::KEY_ATTRIBUTE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCapability(DeviceHistoryEvent $event, array $data): void
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return;
        }
        $event->setCapability($data[self::KEY_CAPABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(DeviceHistoryEvent $event, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return;
        }
        $event->setComponent($data[self::KEY_COMPONENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEpoch(DeviceHistoryEvent $event, array $data): void
    {
        if (!isset($data[self::KEY_EPOCH])) {
            return;
        }
        if (!is_int($data[self::KEY_EPOCH])) {
            return;
        }
        $event->setEpoch($data[self::KEY_EPOCH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(DeviceHistoryEvent $event, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $event->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(DeviceHistoryEvent $event, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $event->setValue($data[self::KEY_VALUE]);
    }
}
