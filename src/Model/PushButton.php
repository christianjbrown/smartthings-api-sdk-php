<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PushButton implements PushButtonInterface
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

    public function setArgument(?string $value): PushButtonInterface
    {
        $this->argument = $value;

        return $this;
    }

    public function setArgumentType(?string $value): PushButtonInterface
    {
        $this->argumentType = $value;

        return $this;
    }
}
