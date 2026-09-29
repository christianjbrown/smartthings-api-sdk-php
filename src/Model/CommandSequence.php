<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandSequence implements CommandSequenceInterface
{
    private ?string $commands = null;
    private ?string $devices = null;

    public function getCommands(): ?string
    {
        return $this->commands;
    }

    public function getDevices(): ?string
    {
        return $this->devices;
    }

    public function setCommands(?string $value): CommandSequenceInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setDevices(?string $value): CommandSequenceInterface
    {
        $this->devices = $value;

        return $this;
    }
}
