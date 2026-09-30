<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PanelForDeviceConfig;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;

final class PanelForDeviceConfigTransformer implements PanelForDeviceConfigTransformerInterface
{
    private PanelForDeviceConfigItemsItemTransformerInterface $panelForDeviceConfigItemsItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(PanelForDeviceConfigItemsItemTransformerInterface $panelForDeviceConfigItemsItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->panelForDeviceConfigItemsItemTransformer = $panelForDeviceConfigItemsItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelForDeviceConfigInterface
    {
        $model = new PanelForDeviceConfig($this->requireItems($data));

        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);
        self::applyHideDashboardActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideDashboardActions(PanelForDeviceConfig $model, array $data): void
    {
        if (!isset($data[self::KEY_HIDE_DASHBOARD_ACTIONS])) {
            return;
        }
        if (!is_bool($data[self::KEY_HIDE_DASHBOARD_ACTIONS])) {
            return;
        }
        $model->setHideDashboardActions($data[self::KEY_HIDE_DASHBOARD_ACTIONS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(PanelForDeviceConfig $model, array $data): void
    {
        if (empty($data[self::KEY_OPERATOR])) {
            return;
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            return;
        }
        $model->setOperator($data[self::KEY_OPERATOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleConditions(PanelForDeviceConfig $model, array $data): void
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
     *
     * @return array<int, PanelForDeviceConfigItemsItemInterface>
     */
    private function requireItems(array $data): array
    {
        if (!isset($data[self::KEY_ITEMS])) {
            return [];
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            return [];
        }

        return $this->transformListPanelForDeviceConfigItemsItem($data[self::KEY_ITEMS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PanelForDeviceConfigItemsItemInterface>
     */
    private function transformListPanelForDeviceConfigItemsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): PanelForDeviceConfigItemsItemInterface => $this->panelForDeviceConfigItemsItemTransformer->transform($item), array_filter($data, is_array(...))));
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
