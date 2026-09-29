<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItem;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItemInterface;

use function is_string;

final class GroupDeviceDetailsDevicesItemComponentsItemTransformer implements GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GroupDeviceDetailsDevicesItemComponentsItemInterface
    {
        $model = new GroupDeviceDetailsDevicesItemComponentsItem();

        self::applyId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(GroupDeviceDetailsDevicesItemComponentsItem $model, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }
}
