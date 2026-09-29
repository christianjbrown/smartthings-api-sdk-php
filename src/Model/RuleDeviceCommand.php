<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RuleDeviceCommand implements RuleDeviceCommandInterface
{
    /**
     * @var null|mixed[]
     */
    private ?array $arguments = null;
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
     * @return null|mixed[]
     */
    public function getArguments(): ?array
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
     * @param null|mixed[] $value
     */
    public function setArguments(?array $value): RuleDeviceCommandInterface
    {
        $this->arguments = $value;

        return $this;
    }

    public function setCommandId(?string $value): RuleDeviceCommandInterface
    {
        $this->commandId = $value;

        return $this;
    }

    public function setComponent(?string $value): RuleDeviceCommandInterface
    {
        $this->component = $value;

        return $this;
    }
}
