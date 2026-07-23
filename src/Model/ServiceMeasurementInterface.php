<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceMeasurementInterface
{
    public function getUnit(): ?string;

    public function getValue(): float|int|string;

    public function setUnit(?string $value): self;

    public function setValue(float|int|string $value): self;
}
