<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceMeasurement implements ServiceMeasurementInterface
{
    private ?string $unit = null;
    private float|int|string $value;

    public function __construct(float|int|string $value)
    {
        $this->value = $value;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getValue(): float|int|string
    {
        return $this->value;
    }

    public function setUnit(?string $value): ServiceMeasurementInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValue(float|int|string $value): ServiceMeasurementInterface
    {
        $this->value = $value;

        return $this;
    }
}
