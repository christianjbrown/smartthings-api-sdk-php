<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapability;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;
use ChristianBrown\SmartThings\Model\StateItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DashboardForCapabilityTransformer implements DashboardForCapabilityTransformerInterface
{
    private ActionItemTransformerInterface $actionItemTransformer;
    private PanelItemForCapabilityTransformerInterface $panelItemForCapabilityTransformer;
    private StateItemTransformerInterface $stateItemTransformer;

    public function __construct(StateItemTransformerInterface $stateItemTransformer, ActionItemTransformerInterface $actionItemTransformer, PanelItemForCapabilityTransformerInterface $panelItemForCapabilityTransformer)
    {
        $this->stateItemTransformer = $stateItemTransformer;
        $this->actionItemTransformer = $actionItemTransformer;
        $this->panelItemForCapabilityTransformer = $panelItemForCapabilityTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DashboardForCapabilityInterface
    {
        $model = new DashboardForCapability();

        $this->applyStates($model, $data);
        $this->applyActions($model, $data);
        $this->applyPanelItems($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(DashboardForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListActionItem($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPanelItems(DashboardForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_PANEL_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_PANEL_ITEMS])) {
            return;
        }
        $model->setPanelItems($this->transformListPanelItemForCapability($data[self::KEY_PANEL_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStates(DashboardForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_STATES])) {
            return;
        }
        if (!is_array($data[self::KEY_STATES])) {
            return;
        }
        $model->setStates($this->transformListStateItem($data[self::KEY_STATES]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionItemInterface>
     */
    private function transformListActionItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ActionItemInterface => $this->actionItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PanelItemForCapabilityInterface>
     */
    private function transformListPanelItemForCapability(array $data): array
    {
        return array_values(array_map(fn (array $item): PanelItemForCapabilityInterface => $this->panelItemForCapabilityTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, StateItemInterface>
     */
    private function transformListStateItem(array $data): array
    {
        return array_values(array_map(fn (array $item): StateItemInterface => $this->stateItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
