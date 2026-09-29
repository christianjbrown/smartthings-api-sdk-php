<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AutomationInterface
{
    /**
     * @return null|array<int, ActionListItemInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, AutomationListItemInterface>
     */
    public function getConditions(): ?array;

    public function getDescriptions(): ?DescriptionsInAutomationInterface;

    /**
     * @param null|array<int, ActionListItemInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, AutomationListItemInterface> $value
     */
    public function setConditions(?array $value): self;

    public function setDescriptions(?DescriptionsInAutomationInterface $value): self;
}
