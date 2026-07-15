<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceStatusRelativeHumidityMeasurementHumidityInterface
{
    public function getTimestamp(): int;

    public function getUnit(): string;

    public function getValue(): float;

    public function setTimestamp(int $value): self;

    public function setUnit(string $value): self;

    public function setValue(float $value): self;
}
