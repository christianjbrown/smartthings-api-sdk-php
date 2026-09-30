<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandActionExecutionResult implements CommandActionExecutionResultInterface
{
    /**
     * @var array<int, array<array-key, mixed>>
     */
    private array $arguments = [];
    private ?string $capability = null;
    private ?string $command = null;
    private ?string $component = null;
    private ?string $deviceId = null;
    private ?string $result = null;

    /**
     * @return array<int, array<array-key, mixed>>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * @param array<int, array<array-key, mixed>> $value
     */
    public function setArguments(array $value): CommandActionExecutionResultInterface
    {
        $this->arguments = $value;

        return $this;
    }

    public function setCapability(?string $value): CommandActionExecutionResultInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setCommand(?string $value): CommandActionExecutionResultInterface
    {
        $this->command = $value;

        return $this;
    }

    public function setComponent(?string $value): CommandActionExecutionResultInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setDeviceId(?string $value): CommandActionExecutionResultInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setResult(?string $value): CommandActionExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }
}
