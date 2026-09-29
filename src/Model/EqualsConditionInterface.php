<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EqualsConditionInterface
{
    public function getAggregation(): ?string;

    public function getChangesOnly(): ?bool;

    public function getLeft(): OperandInterface;

    public function getRight(): OperandInterface;

    public function setAggregation(?string $value): self;

    public function setChangesOnly(?bool $value): self;
}
