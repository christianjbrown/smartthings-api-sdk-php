<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationRequestAutomation implements DeviceConfigurationRequestAutomationInterface
{
    /**
     * @var null|array<int, ExcludedDeviceActionConfigEntryInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, ExcludedDeviceConditionConfigEntryInterface>
     */
    private ?array $conditions = null;

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

    /**
     * @param null|array<int, ExcludedDeviceActionConfigEntryInterface> $value
     */
    public function setActions(?array $value): DeviceConfigurationRequestAutomationInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, ExcludedDeviceConditionConfigEntryInterface> $value
     */
    public function setConditions(?array $value): DeviceConfigurationRequestAutomationInterface
    {
        $this->conditions = $value;

        return $this;
    }
}
