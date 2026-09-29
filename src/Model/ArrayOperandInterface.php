<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ArrayOperandInterface
{
    public function getAggregation(): ?string;

    /**
     * @return array<int, OperandInterface>
     */
    public function getOperands(): array;

    public function setAggregation(?string $value): self;
}
