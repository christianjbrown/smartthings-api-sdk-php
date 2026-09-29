<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StandbyPowerSwitchInterface
{
    public function getCommand(): ToggleSwitchForDashboardCommandInterface;

    public function getState(): ?StandbyPowerSwitchForDashboardStateInterface;

    public function setState(?StandbyPowerSwitchForDashboardStateInterface $value): self;
}
