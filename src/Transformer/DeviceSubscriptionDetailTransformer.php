<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetail;
use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetailInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;

final class DeviceSubscriptionDetailTransformer implements DeviceSubscriptionDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceSubscriptionDetailInterface
    {
        $model = new DeviceSubscriptionDetail(self::requireDeviceId($data));

        self::applyComponentId($model, $data);
        self::applyCapability($model, $data);
        self::applyAttribute($model, $data);
        self::applyValue($model, $data);
        self::applyStateChangeOnly($model, $data);
        self::applySubscriptionName($model, $data);
        self::applyModes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAttribute(DeviceSubscriptionDetail $model, array $data): void
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        $model->setAttribute($data[self::KEY_ATTRIBUTE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCapability(DeviceSubscriptionDetail $model, array $data): void
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return;
        }
        $model->setCapability($data[self::KEY_CAPABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponentId(DeviceSubscriptionDetail $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT_ID])) {
            return;
        }
        $model->setComponentId($data[self::KEY_COMPONENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModes(DeviceSubscriptionDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_MODES])) {
            return;
        }
        if (!is_array($data[self::KEY_MODES])) {
            return;
        }
        $model->setModes(array_values(array_filter($data[self::KEY_MODES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateChangeOnly(DeviceSubscriptionDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE_CHANGE_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_STATE_CHANGE_ONLY])) {
            return;
        }
        $model->setStateChangeOnly($data[self::KEY_STATE_CHANGE_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionName(DeviceSubscriptionDetail $model, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        $model->setSubscriptionName($data[self::KEY_SUBSCRIPTION_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(DeviceSubscriptionDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceId(array $data): ?string
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            return null;
        }

        return $data[self::KEY_DEVICE_ID];
    }
}
