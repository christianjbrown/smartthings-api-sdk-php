<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionsArrayItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemForPresentationInterface;
use ChristianBrown\SmartThings\Model\Dashboard;
use ChristianBrown\SmartThings\Model\DashboardInterface;
use ChristianBrown\SmartThings\Model\StatesArrayItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DashboardTransformer implements DashboardTransformerInterface
{
    private ActionsArrayItemTransformerInterface $actionsArrayItemTransformer;
    private BasicPlusItemForPresentationTransformerInterface $basicPlusItemForPresentationTransformer;
    private GroupVisibleConditionsTransformerInterface $groupVisibleConditionsTransformer;
    private StatesArrayItemTransformerInterface $statesArrayItemTransformer;

    public function __construct(StatesArrayItemTransformerInterface $statesArrayItemTransformer, ActionsArrayItemTransformerInterface $actionsArrayItemTransformer, BasicPlusItemForPresentationTransformerInterface $basicPlusItemForPresentationTransformer, GroupVisibleConditionsTransformerInterface $groupVisibleConditionsTransformer)
    {
        $this->statesArrayItemTransformer = $statesArrayItemTransformer;
        $this->actionsArrayItemTransformer = $actionsArrayItemTransformer;
        $this->basicPlusItemForPresentationTransformer = $basicPlusItemForPresentationTransformer;
        $this->groupVisibleConditionsTransformer = $groupVisibleConditionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DashboardInterface
    {
        $model = new Dashboard();

        $this->applyStates($model, $data);
        $this->applyActions($model, $data);
        $this->applyBasicPlus($model, $data);
        $this->applyGroupVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(Dashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListActionsArrayItem($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBasicPlus(Dashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_BASIC_PLUS])) {
            return;
        }
        if (!is_array($data[self::KEY_BASIC_PLUS])) {
            return;
        }
        $model->setBasicPlus($this->transformListBasicPlusItemForPresentation($data[self::KEY_BASIC_PLUS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyGroupVisibleConditions(Dashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_GROUP_VISIBLE_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_GROUP_VISIBLE_CONDITIONS])) {
            return;
        }
        $model->setGroupVisibleConditions($this->groupVisibleConditionsTransformer->transform($data[self::KEY_GROUP_VISIBLE_CONDITIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStates(Dashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_STATES])) {
            return;
        }
        if (!is_array($data[self::KEY_STATES])) {
            return;
        }
        $model->setStates($this->transformListStatesArrayItem($data[self::KEY_STATES]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionsArrayItemInterface>
     */
    private function transformListActionsArrayItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ActionsArrayItemInterface => $this->actionsArrayItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BasicPlusItemForPresentationInterface>
     */
    private function transformListBasicPlusItemForPresentation(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusItemForPresentationInterface => $this->basicPlusItemForPresentationTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, StatesArrayItemInterface>
     */
    private function transformListStatesArrayItem(array $data): array
    {
        return array_values(array_map(fn (array $item): StatesArrayItemInterface => $this->statesArrayItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
