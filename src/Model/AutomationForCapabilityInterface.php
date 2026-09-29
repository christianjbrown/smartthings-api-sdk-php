<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AutomationForCapabilityInterface
{
    /**
     * @return null|array<int, AutomationForCapabilityActionsItemInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, AutomationForCapabilityConditionsItemInterface>
     */
    public function getConditions(): ?array;

    /**
     * @param null|array<int, AutomationForCapabilityActionsItemInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, AutomationForCapabilityConditionsItemInterface> $value
     */
    public function setConditions(?array $value): self;
}
