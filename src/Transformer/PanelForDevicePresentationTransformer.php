<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentation;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentationInterface;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentationItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class PanelForDevicePresentationTransformer implements PanelForDevicePresentationTransformerInterface
{
    private PanelForDevicePresentationItemsItemTransformerInterface $panelForDevicePresentationItemsItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(PanelForDevicePresentationItemsItemTransformerInterface $panelForDevicePresentationItemsItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->panelForDevicePresentationItemsItemTransformer = $panelForDevicePresentationItemsItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelForDevicePresentationInterface
    {
        $model = new PanelForDevicePresentation($this->requireItems($data));

        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);
        self::applyHideDashboardActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideDashboardActions(PanelForDevicePresentation $model, array $data): void
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
    private static function applyOperator(PanelForDevicePresentation $model, array $data): void
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
    private function applyVisibleConditions(PanelForDevicePresentation $model, array $data): void
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
     * @return array<int, PanelForDevicePresentationItemsItemInterface>
     */
    private function requireItems(array $data): array
    {
        if (!isset($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_ITEMS));
        }

        return $this->transformListPanelForDevicePresentationItemsItem($data[self::KEY_ITEMS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PanelForDevicePresentationItemsItemInterface>
     */
    private function transformListPanelForDevicePresentationItemsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): PanelForDevicePresentationItemsItemInterface => $this->panelForDevicePresentationItemsItemTransformer->transform($item), array_filter($data, is_array(...))));
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
