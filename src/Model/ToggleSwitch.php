<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ToggleSwitch implements ToggleSwitchInterface
{
    private ?ToggleSwitchForDashboardCommandInterface $command;
    private ?StandbyPowerSwitchForDashboardStateInterface $state = null;

    public function __construct(?ToggleSwitchForDashboardCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand(): ?ToggleSwitchForDashboardCommandInterface
    {
        return $this->command;
    }

    public function getState(): ?StandbyPowerSwitchForDashboardStateInterface
    {
        return $this->state;
    }

    public function setState(?StandbyPowerSwitchForDashboardStateInterface $value): ToggleSwitchInterface
    {
        $this->state = $value;

        return $this;
    }
}
