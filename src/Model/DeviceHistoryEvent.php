<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceHistoryEvent implements DeviceHistoryEventInterface
{
    private ?string $attribute = null;
    private ?string $capability = null;
    private ?string $component = null;
    private string $deviceId;
    private ?int $epoch = null;
    private ?string $locationId = null;
    private ?string $value = null;

    public function __construct(string $deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    public function getEpoch(): ?int
    {
        return $this->epoch;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setAttribute(?string $value): DeviceHistoryEventInterface
    {
        $this->attribute = $value;

        return $this;
    }

    public function setCapability(?string $value): DeviceHistoryEventInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setComponent(?string $value): DeviceHistoryEventInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setDeviceId(string $value): DeviceHistoryEventInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setEpoch(?int $value): DeviceHistoryEventInterface
    {
        $this->epoch = $value;

        return $this;
    }

    public function setLocationId(?string $value): DeviceHistoryEventInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setValue(?string $value): DeviceHistoryEventInterface
    {
        $this->value = $value;

        return $this;
    }
}
