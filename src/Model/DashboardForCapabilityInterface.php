<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DashboardForCapabilityInterface
{
    /**
     * @return null|array<int, ActionItemInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, PanelItemForCapabilityInterface>
     */
    public function getPanelItems(): ?array;

    /**
     * @return null|array<int, StateItemInterface>
     */
    public function getStates(): ?array;

    /**
     * @param null|array<int, ActionItemInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, PanelItemForCapabilityInterface> $value
     */
    public function setPanelItems(?array $value): self;

    /**
     * @param null|array<int, StateItemInterface> $value
     */
    public function setStates(?array $value): self;
}
