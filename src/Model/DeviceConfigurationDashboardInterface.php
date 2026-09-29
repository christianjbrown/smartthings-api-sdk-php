<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationDashboardInterface
{
    /**
     * @return null|array<int, DeviceConfigEntryForDashboardActionInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, BasicPlusItemInterface>
     */
    public function getBasicPlus(): ?array;

    public function getGroupVisibleConditions(): ?GroupVisibleConditionsInterface;

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateInterface>
     */
    public function getStates(): ?array;

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardActionInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, BasicPlusItemInterface> $value
     */
    public function setBasicPlus(?array $value): self;

    public function setGroupVisibleConditions(?GroupVisibleConditionsInterface $value): self;

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateInterface> $value
     */
    public function setStates(?array $value): self;
}
