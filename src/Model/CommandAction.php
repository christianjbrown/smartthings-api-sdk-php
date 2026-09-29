<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandAction implements CommandActionInterface
{
    /**
     * @var array<int, RuleDeviceCommandInterface>
     */
    private array $commands;

    /**
     * @var array<int, string>
     */
    private array $devices;
    private ?CommandSequenceInterface $sequence = null;

    /**
     * @phpstan-param array<int, string> $devices
     * @phpstan-param array<int, RuleDeviceCommandInterface> $commands
     */
    public function __construct(array $devices, array $commands)
    {
        $this->devices = $devices;
        $this->commands = $commands;
    }

    /**
     * @return array<int, RuleDeviceCommandInterface>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @return array<int, string>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    public function getSequence(): ?CommandSequenceInterface
    {
        return $this->sequence;
    }

    public function setSequence(?CommandSequenceInterface $value): CommandActionInterface
    {
        $this->sequence = $value;

        return $this;
    }
}
