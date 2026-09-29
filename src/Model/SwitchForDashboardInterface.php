<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SwitchForDashboardInterface
{
    public function getCommand(): ToggleSwitchForDashboardCommandInterface;

    public function getState(): ?ToggleSwitchForDashboardStateInterface;

    public function setState(?ToggleSwitchForDashboardStateInterface $value): self;
}
