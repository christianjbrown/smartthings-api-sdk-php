<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceStatusBatteryBatteryInterface
{
    public function getTimestamp(): int;

    public function getUnit(): string;

    public function getValue(): int;

    public function setTimestamp(int $value): self;

    public function setUnit(string $value): self;

    public function setValue(int $value): self;
}
