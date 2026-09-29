<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceHealthDetail;
use ChristianBrown\SmartThings\Model\DeviceHealthDetailInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class DeviceHealthDetailTransformer implements DeviceHealthDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceHealthDetailInterface
    {
        $model = new DeviceHealthDetail();

        self::applyDeviceIds($model, $data);
        self::applySubscriptionName($model, $data);
        self::applyLocationId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceIds(DeviceHealthDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_IDS])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_IDS])) {
            return;
        }
        $model->setDeviceIds(array_values(array_filter($data[self::KEY_DEVICE_IDS], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(DeviceHealthDetail $model, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $model->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionName(DeviceHealthDetail $model, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        $model->setSubscriptionName($data[self::KEY_SUBSCRIPTION_NAME]);
    }
}
