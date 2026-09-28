<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceCommand implements DeviceCommandInterface
{
    /**
     * @var mixed[]
     */
    private array $arguments = [];
    private string $capability;
    private string $command;
    private ?string $commandId = null;
    private ?string $component = null;

    public function __construct(string $capability, string $command)
    {
        $this->capability = $capability;
        $this->command = $command;
    }

    /**
     * @return mixed[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getCommandId(): ?string
    {
        return $this->commandId;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    /**
     * @param mixed[] $value
     */
    public function setArguments(array $value): DeviceCommandInterface
    {
        $this->arguments = $value;

        return $this;
    }

    public function setCommandId(?string $value): DeviceCommandInterface
    {
        $this->commandId = $value;

        return $this;
    }

    public function setComponent(?string $value): DeviceCommandInterface
    {
        $this->component = $value;

        return $this;
    }
}
