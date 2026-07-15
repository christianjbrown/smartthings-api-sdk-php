<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceStatusRelativeHumidityMeasurementHumidity implements DeviceStatusRelativeHumidityMeasurementHumidityInterface
{
    private int $timestamp;
    private string $unit;
    private float $value;

    public function __construct(int $timestamp, string $unit, float $value)
    {
        $this->timestamp = $timestamp;
        $this->unit = $unit;
        $this->value = $value;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setTimestamp(int $value): DeviceStatusRelativeHumidityMeasurementHumidityInterface
    {
        $this->timestamp = $value;

        return $this;
    }

    public function setUnit(string $value): DeviceStatusRelativeHumidityMeasurementHumidityInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValue(float $value): DeviceStatusRelativeHumidityMeasurementHumidityInterface
    {
        $this->value = $value;

        return $this;
    }
}
