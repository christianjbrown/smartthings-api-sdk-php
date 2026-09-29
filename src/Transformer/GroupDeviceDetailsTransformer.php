<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetails;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemInterface;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class GroupDeviceDetailsTransformer implements GroupDeviceDetailsTransformerInterface
{
    private GroupDeviceDetailsDevicesItemTransformerInterface $groupDeviceDetailsDevicesItemTransformer;

    public function __construct(GroupDeviceDetailsDevicesItemTransformerInterface $groupDeviceDetailsDevicesItemTransformer)
    {
        $this->groupDeviceDetailsDevicesItemTransformer = $groupDeviceDetailsDevicesItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GroupDeviceDetailsInterface
    {
        $model = new GroupDeviceDetails();

        self::applyGroupName($model, $data);
        self::applyGroupType($model, $data);
        $this->applyDevices($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDevices(GroupDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return;
        }
        $model->setDevices($this->transformListGroupDeviceDetailsDevicesItem($data[self::KEY_DEVICES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroupName(GroupDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_GROUP_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_GROUP_NAME])) {
            return;
        }
        $model->setGroupName($data[self::KEY_GROUP_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroupType(GroupDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_GROUP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_GROUP_TYPE])) {
            return;
        }
        $model->setGroupType($data[self::KEY_GROUP_TYPE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, GroupDeviceDetailsDevicesItemInterface>
     */
    private function transformListGroupDeviceDetailsDevicesItem(array $data): array
    {
        return array_values(array_map(fn (array $item): GroupDeviceDetailsDevicesItemInterface => $this->groupDeviceDetailsDevicesItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
