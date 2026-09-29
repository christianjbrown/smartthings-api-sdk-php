<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionListItemInterface;
use ChristianBrown\SmartThings\Model\Automation;
use ChristianBrown\SmartThings\Model\AutomationInterface;
use ChristianBrown\SmartThings\Model\AutomationListItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class AutomationTransformer implements AutomationTransformerInterface
{
    private ActionListItemTransformerInterface $actionListItemTransformer;
    private AutomationListItemTransformerInterface $automationListItemTransformer;
    private DescriptionsInAutomationTransformerInterface $descriptionsInAutomationTransformer;

    public function __construct(AutomationListItemTransformerInterface $automationListItemTransformer, ActionListItemTransformerInterface $actionListItemTransformer, DescriptionsInAutomationTransformerInterface $descriptionsInAutomationTransformer)
    {
        $this->automationListItemTransformer = $automationListItemTransformer;
        $this->actionListItemTransformer = $actionListItemTransformer;
        $this->descriptionsInAutomationTransformer = $descriptionsInAutomationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutomationInterface
    {
        $model = new Automation();

        $this->applyConditions($model, $data);
        $this->applyActions($model, $data);
        $this->applyDescriptions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(Automation $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListActionListItem($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConditions(Automation $model, array $data): void
    {
        if (!isset($data[self::KEY_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CONDITIONS])) {
            return;
        }
        $model->setConditions($this->transformListAutomationListItem($data[self::KEY_CONDITIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDescriptions(Automation $model, array $data): void
    {
        if (!isset($data[self::KEY_DESCRIPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_DESCRIPTIONS])) {
            return;
        }
        $model->setDescriptions($this->descriptionsInAutomationTransformer->transform($data[self::KEY_DESCRIPTIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionListItemInterface>
     */
    private function transformListActionListItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ActionListItemInterface => $this->actionListItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AutomationListItemInterface>
     */
    private function transformListAutomationListItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AutomationListItemInterface => $this->automationListItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
