<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapability;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class AutomationForCapabilityTransformer implements AutomationForCapabilityTransformerInterface
{
    private AutomationForCapabilityActionsItemTransformerInterface $automationForCapabilityActionsItemTransformer;
    private AutomationForCapabilityConditionsItemTransformerInterface $automationForCapabilityConditionsItemTransformer;

    public function __construct(AutomationForCapabilityConditionsItemTransformerInterface $automationForCapabilityConditionsItemTransformer, AutomationForCapabilityActionsItemTransformerInterface $automationForCapabilityActionsItemTransformer)
    {
        $this->automationForCapabilityConditionsItemTransformer = $automationForCapabilityConditionsItemTransformer;
        $this->automationForCapabilityActionsItemTransformer = $automationForCapabilityActionsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutomationForCapabilityInterface
    {
        $model = new AutomationForCapability();

        $this->applyConditions($model, $data);
        $this->applyActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(AutomationForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListAutomationForCapabilityActionsItem($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConditions(AutomationForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CONDITIONS])) {
            return;
        }
        $model->setConditions($this->transformListAutomationForCapabilityConditionsItem($data[self::KEY_CONDITIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AutomationForCapabilityActionsItemInterface>
     */
    private function transformListAutomationForCapabilityActionsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AutomationForCapabilityActionsItemInterface => $this->automationForCapabilityActionsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AutomationForCapabilityConditionsItemInterface>
     */
    private function transformListAutomationForCapabilityConditionsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AutomationForCapabilityConditionsItemInterface => $this->automationForCapabilityConditionsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
