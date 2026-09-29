<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DashboardForCapability implements DashboardForCapabilityInterface
{
    /**
     * @var null|array<int, ActionItemInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, PanelItemForCapabilityInterface>
     */
    private ?array $panelItems = null;

    /**
     * @var null|array<int, StateItemInterface>
     */
    private ?array $states = null;

    /**
     * @return null|array<int, ActionItemInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, PanelItemForCapabilityInterface>
     */
    public function getPanelItems(): ?array
    {
        return $this->panelItems;
    }

    /**
     * @return null|array<int, StateItemInterface>
     */
    public function getStates(): ?array
    {
        return $this->states;
    }

    /**
     * @param null|array<int, ActionItemInterface> $value
     */
    public function setActions(?array $value): DashboardForCapabilityInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, PanelItemForCapabilityInterface> $value
     */
    public function setPanelItems(?array $value): DashboardForCapabilityInterface
    {
        $this->panelItems = $value;

        return $this;
    }

    /**
     * @param null|array<int, StateItemInterface> $value
     */
    public function setStates(?array $value): DashboardForCapabilityInterface
    {
        $this->states = $value;

        return $this;
    }
}
