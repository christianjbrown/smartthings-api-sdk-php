<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceStatusBatteryInterface
{
    public function getBattery(): DeviceStatusBatteryBatteryInterface;

    public function setBattery(DeviceStatusBatteryBatteryInterface $value): self;
}
