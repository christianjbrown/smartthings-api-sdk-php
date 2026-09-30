<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class DeviceConfigurationIconsItemBadgeItemTransformer implements DeviceConfigurationIconsItemBadgeItemTransformerInterface
{
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationIconsItemBadgeItemInterface
    {
        $model = new DeviceConfigurationIconsItemBadgeItem(self::requireIconUrl($data));

        $this->applyVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleConditions(DeviceConfigurationIconsItemBadgeItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        $model->setVisibleConditions($this->transformListVisibleCondition($data[self::KEY_VISIBLE_CONDITIONS]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireIconUrl(array $data): ?string
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return null;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return null;
        }

        return $data[self::KEY_ICON_URL];
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
