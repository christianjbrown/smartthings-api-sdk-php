<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DescriptionsInAutomation implements DescriptionsInAutomationInterface
{
    /**
     * @var null|array<int, DescriptionItemInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, DescriptionItemInterface>
     */
    private ?array $conditions = null;

    /**
     * @return null|array<int, DescriptionItemInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, DescriptionItemInterface>
     */
    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    /**
     * @param null|array<int, DescriptionItemInterface> $value
     */
    public function setActions(?array $value): DescriptionsInAutomationInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, DescriptionItemInterface> $value
     */
    public function setConditions(?array $value): DescriptionsInAutomationInterface
    {
        $this->conditions = $value;

        return $this;
    }
}
