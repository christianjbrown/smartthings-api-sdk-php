<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceHealth implements DeviceHealthInterface
{
    private string $deviceId;
    private ?int $lastUpdatedDate = null;
    private ?string $state = null;

    public function __construct(string $deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    public function getLastUpdatedDate(): ?int
    {
        return $this->lastUpdatedDate;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setDeviceId(string $value): DeviceHealthInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setLastUpdatedDate(?int $value): DeviceHealthInterface
    {
        $this->lastUpdatedDate = $value;

        return $this;
    }

    public function setState(?string $value): DeviceHealthInterface
    {
        $this->state = $value;

        return $this;
    }
}
