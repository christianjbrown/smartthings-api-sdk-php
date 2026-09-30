<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ToggleSwitchForDashboard implements ToggleSwitchForDashboardInterface
{
    private ?ToggleSwitchForDashboardCommandInterface $command;
    private ?ToggleSwitchForDashboardStateInterface $state = null;

    public function __construct(?ToggleSwitchForDashboardCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand(): ?ToggleSwitchForDashboardCommandInterface
    {
        return $this->command;
    }

    public function getState(): ?ToggleSwitchForDashboardStateInterface
    {
        return $this->state;
    }

    public function setState(?ToggleSwitchForDashboardStateInterface $value): ToggleSwitchForDashboardInterface
    {
        $this->state = $value;

        return $this;
    }
}
