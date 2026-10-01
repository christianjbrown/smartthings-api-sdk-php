<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\DeviceOperand;
use ChristianBrown\SmartThings\Model\DeviceOperandInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

/**
 * Builds DeviceOperandInterface from its decoded JSON.
 */
final class DeviceOperandNodeTransformer implements DeviceOperandNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): DeviceOperandInterface
    {
        $model = new DeviceOperand(self::requireDevices($data), self::requireComponent($data), self::requireCapability($data), self::requireAttribute($data));

        self::applyPath($model, $data);
        self::applyAggregation($model, $data);
        self::applyTrigger($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAggregation(DeviceOperand $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPath(DeviceOperand $model, array $data): void
    {
        if (empty($data[self::KEY_PATH])) {
            return;
        }
        if (!is_string($data[self::KEY_PATH])) {
            return;
        }
        $model->setPath($data[self::KEY_PATH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTrigger(DeviceOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TRIGGER])) {
            return;
        }
        if (!is_string($data[self::KEY_TRIGGER])) {
            return;
        }
        $model->setTrigger($data[self::KEY_TRIGGER]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireAttribute(array $data): ?string
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return null;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return null;
        }

        return $data[self::KEY_ATTRIBUTE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    private static function requireDevices(array $data): array
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return [];
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return [];
        }

        return array_values(array_filter($data[self::KEY_DEVICES], is_string(...)));
    }
}
