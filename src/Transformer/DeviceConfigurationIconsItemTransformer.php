<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class DeviceConfigurationIconsItemTransformer implements DeviceConfigurationIconsItemTransformerInterface
{
    private DeviceConfigurationIconsItemBadgeItemTransformerInterface $deviceConfigurationIconsItemBadgeItemTransformer;
    private DeviceConfigurationIconsItemProductKeysItemTransformerInterface $deviceConfigurationIconsItemProductKeysItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(VisibleConditionTransformerInterface $visibleConditionTransformer, DeviceConfigurationIconsItemBadgeItemTransformerInterface $deviceConfigurationIconsItemBadgeItemTransformer, DeviceConfigurationIconsItemProductKeysItemTransformerInterface $deviceConfigurationIconsItemProductKeysItemTransformer)
    {
        $this->visibleConditionTransformer = $visibleConditionTransformer;
        $this->deviceConfigurationIconsItemBadgeItemTransformer = $deviceConfigurationIconsItemBadgeItemTransformer;
        $this->deviceConfigurationIconsItemProductKeysItemTransformer = $deviceConfigurationIconsItemProductKeysItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationIconsItemInterface
    {
        $model = new DeviceConfigurationIconsItem();

        self::applyGroup($model, $data);
        self::applyIconUrl($model, $data);
        $this->applyRunningConditions($model, $data);
        $this->applyBadge($model, $data);
        $this->applyProductKeys($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBadge(DeviceConfigurationIconsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_BADGE])) {
            return;
        }
        if (!is_array($data[self::KEY_BADGE])) {
            return;
        }
        $model->setBadge($this->transformListDeviceConfigurationIconsItemBadgeItem($data[self::KEY_BADGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroup(DeviceConfigurationIconsItem $model, array $data): void
    {
        if (empty($data[self::KEY_GROUP])) {
            return;
        }
        if (!is_string($data[self::KEY_GROUP])) {
            return;
        }
        $model->setGroup($data[self::KEY_GROUP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIconUrl(DeviceConfigurationIconsItem $model, array $data): void
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return;
        }
        $model->setIconUrl($data[self::KEY_ICON_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProductKeys(DeviceConfigurationIconsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PRODUCT_KEYS])) {
            return;
        }
        if (!is_array($data[self::KEY_PRODUCT_KEYS])) {
            return;
        }
        $model->setProductKeys($this->transformListDeviceConfigurationIconsItemProductKeysItem($data[self::KEY_PRODUCT_KEYS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRunningConditions(DeviceConfigurationIconsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_RUNNING_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_RUNNING_CONDITIONS])) {
            return;
        }
        $model->setRunningConditions($this->transformListVisibleCondition($data[self::KEY_RUNNING_CONDITIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationIconsItemBadgeItemInterface>
     */
    private function transformListDeviceConfigurationIconsItemBadgeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationIconsItemBadgeItemInterface => $this->deviceConfigurationIconsItemBadgeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationIconsItemProductKeysItemInterface>
     */
    private function transformListDeviceConfigurationIconsItemProductKeysItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationIconsItemProductKeysItemInterface => $this->deviceConfigurationIconsItemProductKeysItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, VisibleConditionInterface>
     */
    private function transformListVisibleCondition(array $data): array
    {
        return array_values(array_map(fn (array $item): VisibleConditionInterface => $this->visibleConditionTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
