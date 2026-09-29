<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LessThanCondition implements LessThanConditionInterface
{
    private ?string $aggregation = null;
    private ?bool $changesOnly = null;
    private OperandInterface $left;
    private OperandInterface $right;

    public function __construct(OperandInterface $left, OperandInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function getAggregation(): ?string
    {
        return $this->aggregation;
    }

    public function getChangesOnly(): ?bool
    {
        return $this->changesOnly;
    }

    public function getLeft(): OperandInterface
    {
        return $this->left;
    }

    public function getRight(): OperandInterface
    {
        return $this->right;
    }

    public function setAggregation(?string $value): LessThanConditionInterface
    {
        $this->aggregation = $value;

        return $this;
    }

    public function setChangesOnly(?bool $value): LessThanConditionInterface
    {
        $this->changesOnly = $value;

        return $this;
    }
}
