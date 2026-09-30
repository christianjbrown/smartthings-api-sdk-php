<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Interval implements IntervalInterface
{
    private ?string $unit;
    private ?OperandInterface $value;

    public function __construct(?OperandInterface $value, ?string $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getValue(): ?OperandInterface
    {
        return $this->value;
    }
}
