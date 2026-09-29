<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboard;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DeviceConfigurationDashboardTransformer implements DeviceConfigurationDashboardTransformerInterface
{
    private BasicPlusItemTransformerInterface $basicPlusItemTransformer;
    private DeviceConfigEntryForDashboardActionTransformerInterface $deviceConfigEntryForDashboardActionTransformer;
    private DeviceConfigEntryForDashboardStateTransformerInterface $deviceConfigEntryForDashboardStateTransformer;
    private GroupVisibleConditionsTransformerInterface $groupVisibleConditionsTransformer;

    public function __construct(DeviceConfigEntryForDashboardStateTransformerInterface $deviceConfigEntryForDashboardStateTransformer, DeviceConfigEntryForDashboardActionTransformerInterface $deviceConfigEntryForDashboardActionTransformer, BasicPlusItemTransformerInterface $basicPlusItemTransformer, GroupVisibleConditionsTransformerInterface $groupVisibleConditionsTransformer)
    {
        $this->deviceConfigEntryForDashboardStateTransformer = $deviceConfigEntryForDashboardStateTransformer;
        $this->deviceConfigEntryForDashboardActionTransformer = $deviceConfigEntryForDashboardActionTransformer;
        $this->basicPlusItemTransformer = $basicPlusItemTransformer;
        $this->groupVisibleConditionsTransformer = $groupVisibleConditionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDashboardInterface
    {
        $model = new DeviceConfigurationDashboard();

        $this->applyStates($model, $data);
        $this->applyActions($model, $data);
        $this->applyBasicPlus($model, $data);
        $this->applyGroupVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(DeviceConfigurationDashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListDeviceConfigEntryForDashboardAction($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBasicPlus(DeviceConfigurationDashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_BASIC_PLUS])) {
            return;
        }
        if (!is_array($data[self::KEY_BASIC_PLUS])) {
            return;
        }
        $model->setBasicPlus($this->transformListBasicPlusItem($data[self::KEY_BASIC_PLUS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyGroupVisibleConditions(DeviceConfigurationDashboard $model, array $data): void
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
    private function applyStates(DeviceConfigurationDashboard $model, array $data): void
    {
        if (!isset($data[self::KEY_STATES])) {
            return;
        }
        if (!is_array($data[self::KEY_STATES])) {
            return;
        }
        $model->setStates($this->transformListDeviceConfigEntryForDashboardState($data[self::KEY_STATES]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BasicPlusItemInterface>
     */
    private function transformListBasicPlusItem(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusItemInterface => $this->basicPlusItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigEntryForDashboardActionInterface>
     */
    private function transformListDeviceConfigEntryForDashboardAction(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigEntryForDashboardActionInterface => $this->deviceConfigEntryForDashboardActionTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigEntryForDashboardStateInterface>
     */
    private function transformListDeviceConfigEntryForDashboardState(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigEntryForDashboardStateInterface => $this->deviceConfigEntryForDashboardStateTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
