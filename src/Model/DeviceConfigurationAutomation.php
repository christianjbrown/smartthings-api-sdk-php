<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationAutomation implements DeviceConfigurationAutomationInterface
{
    /**
     * @var null|array<int, ExcludedDeviceActionConfigEntryInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, ExcludedDeviceConditionConfigEntryInterface>
     */
    private ?array $conditions = null;
    private ?DescriptionsInAutomationInterface $descriptions = null;

    /**
     * @return null|array<int, ExcludedDeviceActionConfigEntryInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, ExcludedDeviceConditionConfigEntryInterface>
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
     * @param null|array<int, ExcludedDeviceActionConfigEntryInterface> $value
     */
    public function setActions(?array $value): DeviceConfigurationAutomationInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, ExcludedDeviceConditionConfigEntryInterface> $value
     */
    public function setConditions(?array $value): DeviceConfigurationAutomationInterface
    {
        $this->conditions = $value;

        return $this;
    }

    public function setDescriptions(?DescriptionsInAutomationInterface $value): DeviceConfigurationAutomationInterface
    {
        $this->descriptions = $value;

        return $this;
    }
}
