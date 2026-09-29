<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceResults implements DeviceResultsInterface
{
    private ?string $deviceId = null;
    private ?string $name = null;

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setDeviceId(?string $value): DeviceResultsInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setName(?string $value): DeviceResultsInterface
    {
        $this->name = $value;

        return $this;
    }
}
