<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AutomationForCapability implements AutomationForCapabilityInterface
{
    /**
     * @var null|array<int, AutomationForCapabilityActionsItemInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, AutomationForCapabilityConditionsItemInterface>
     */
    private ?array $conditions = null;

    /**
     * @return null|array<int, AutomationForCapabilityActionsItemInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, AutomationForCapabilityConditionsItemInterface>
     */
    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    /**
     * @param null|array<int, AutomationForCapabilityActionsItemInterface> $value
     */
    public function setActions(?array $value): AutomationForCapabilityInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, AutomationForCapabilityConditionsItemInterface> $value
     */
    public function setConditions(?array $value): AutomationForCapabilityInterface
    {
        $this->conditions = $value;

        return $this;
    }
}
