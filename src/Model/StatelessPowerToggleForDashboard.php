<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StatelessPowerToggleForDashboard implements StatelessPowerToggleForDashboardInterface
{
    private ?string $argument = null;
    private ?string $argumentType = null;
    private string $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getArgument(): ?string
    {
        return $this->argument;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function setArgument(?string $value): StatelessPowerToggleForDashboardInterface
    {
        $this->argument = $value;

        return $this;
    }

    public function setArgumentType(?string $value): StatelessPowerToggleForDashboardInterface
    {
        $this->argumentType = $value;

        return $this;
    }
}
