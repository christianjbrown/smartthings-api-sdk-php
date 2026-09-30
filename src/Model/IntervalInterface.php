<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IntervalInterface
{
    public function getUnit(): ?string;

    public function getValue(): ?OperandInterface;
}
