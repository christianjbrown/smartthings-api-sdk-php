<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceOperand implements DeviceOperandInterface
{
    private ?string $aggregation = null;
    private string $attribute;
    private string $capability;
    private string $component;

    /**
     * @var array<int, string>
     */
    private array $devices;
    private ?string $path = null;
    private ?string $trigger = null;

    /**
     * @phpstan-param array<int, string> $devices
     */
    public function __construct(array $devices, string $component, string $capability, string $attribute)
    {
        $this->devices = $devices;
        $this->component = $component;
        $this->capability = $capability;
        $this->attribute = $attribute;
    }

    public function getAggregation(): ?string
    {
        return $this->aggregation;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @return array<int, string>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getTrigger(): ?string
    {
        return $this->trigger;
    }

    public function setAggregation(?string $value): DeviceOperandInterface
    {
        $this->aggregation = $value;

        return $this;
    }

    public function setPath(?string $value): DeviceOperandInterface
    {
        $this->path = $value;

        return $this;
    }

    public function setTrigger(?string $value): DeviceOperandInterface
    {
        $this->trigger = $value;

        return $this;
    }
}
