<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceStatusBattery implements DeviceStatusBatteryInterface
{
    private DeviceStatusBatteryBatteryInterface $battery;

    public function __construct(DeviceStatusBatteryBatteryInterface $battery)
    {
        $this->battery = $battery;
    }

    public function getBattery(): DeviceStatusBatteryBatteryInterface
    {
        return $this->battery;
    }

    public function setBattery(DeviceStatusBatteryBatteryInterface $value): self
    {
        $this->battery = $value;

        return $this;
    }
}
