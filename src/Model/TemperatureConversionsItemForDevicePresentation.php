<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TemperatureConversionsItemForDevicePresentation implements TemperatureConversionsItemForDevicePresentationInterface
{
    private ?string $capability;
    private ?string $unit = null;
    private ?string $value;
    private ?int $version = null;

    public function __construct(?string $capability, ?string $value)
    {
        $this->capability = $capability;
        $this->value = $value;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setUnit(?string $value): TemperatureConversionsItemForDevicePresentationInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setVersion(?int $value): TemperatureConversionsItemForDevicePresentationInterface
    {
        $this->version = $value;

        return $this;
    }
}
