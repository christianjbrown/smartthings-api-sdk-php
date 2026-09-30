<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItem;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemComponentsItemInterface;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsDevicesItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class GroupDeviceDetailsDevicesItemTransformer implements GroupDeviceDetailsDevicesItemTransformerInterface
{
    private GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface $groupDeviceDetailsDevicesItemComponentsItemTransformer;

    public function __construct(GroupDeviceDetailsDevicesItemComponentsItemTransformerInterface $groupDeviceDetailsDevicesItemComponentsItemTransformer)
    {
        $this->groupDeviceDetailsDevicesItemComponentsItemTransformer = $groupDeviceDetailsDevicesItemComponentsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GroupDeviceDetailsDevicesItemInterface
    {
        $model = new GroupDeviceDetailsDevicesItem(self::requireDeviceId($data));

        $this->applyComponents($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyComponents(GroupDeviceDetailsDevicesItem $model, array $data): void
    {
        if (!isset($data[self::KEY_COMPONENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPONENTS])) {
            return;
        }
        $model->setComponents($this->transformListGroupDeviceDetailsDevicesItemComponentsItem($data[self::KEY_COMPONENTS]));
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

    /**
     * @param mixed[] $data
     *
     * @return array<int, GroupDeviceDetailsDevicesItemComponentsItemInterface>
     */
    private function transformListGroupDeviceDetailsDevicesItemComponentsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): GroupDeviceDetailsDevicesItemComponentsItemInterface => $this->groupDeviceDetailsDevicesItemComponentsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
