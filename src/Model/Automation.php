<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Automation implements AutomationInterface
{
    /**
     * @var null|array<int, ActionListItemInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, AutomationListItemInterface>
     */
    private ?array $conditions = null;
    private ?DescriptionsInAutomationInterface $descriptions = null;

    /**
     * @return null|array<int, ActionListItemInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, AutomationListItemInterface>
     */
    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    public function getDescriptions(): ?DescriptionsInAutomationInterface
    {
        return $this->descriptions;
    }

    /**
     * @param null|array<int, ActionListItemInterface> $value
     */
    public function setActions(?array $value): AutomationInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, AutomationListItemInterface> $value
     */
    public function setConditions(?array $value): AutomationInterface
    {
        $this->conditions = $value;

        return $this;
    }

    public function setDescriptions(?DescriptionsInAutomationInterface $value): AutomationInterface
    {
        $this->descriptions = $value;

        return $this;
    }
}
