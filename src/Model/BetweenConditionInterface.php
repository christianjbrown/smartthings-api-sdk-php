<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BetweenConditionInterface
{
    public function getAggregation(): ?string;

    public function getChangesOnly(): ?bool;

    public function getEnd(): OperandInterface;

    public function getStart(): OperandInterface;

    public function getValue(): OperandInterface;

    public function setAggregation(?string $value): self;

    public function setChangesOnly(?bool $value): self;
}
