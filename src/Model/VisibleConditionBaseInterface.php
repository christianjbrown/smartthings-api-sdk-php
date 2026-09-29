<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface VisibleConditionBaseInterface
{
    public function getOperand(): string;

    public function getOperator(): string;

    public function getValue(): string;

    public function getValueType(): ?string;

    public function setValueType(?string $value): self;
}
