<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationDashboard implements DeviceConfigurationDashboardInterface
{
    /**
     * @var null|array<int, DeviceConfigEntryForDashboardActionInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, BasicPlusItemInterface>
     */
    private ?array $basicPlus = null;
    private ?GroupVisibleConditionsInterface $groupVisibleConditions = null;

    /**
     * @var null|array<int, DeviceConfigEntryForDashboardStateInterface>
     */
    private ?array $states = null;

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardActionInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, BasicPlusItemInterface>
     */
    public function getBasicPlus(): ?array
    {
        return $this->basicPlus;
    }

    public function getGroupVisibleConditions(): ?GroupVisibleConditionsInterface
    {
        return $this->groupVisibleConditions;
    }

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateInterface>
     */
    public function getStates(): ?array
    {
        return $this->states;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardActionInterface> $value
     */
    public function setActions(?array $value): DeviceConfigurationDashboardInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusItemInterface> $value
     */
    public function setBasicPlus(?array $value): DeviceConfigurationDashboardInterface
    {
        $this->basicPlus = $value;

        return $this;
    }

    public function setGroupVisibleConditions(?GroupVisibleConditionsInterface $value): DeviceConfigurationDashboardInterface
    {
        $this->groupVisibleConditions = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateInterface> $value
     */
    public function setStates(?array $value): DeviceConfigurationDashboardInterface
    {
        $this->states = $value;

        return $this;
    }
}
