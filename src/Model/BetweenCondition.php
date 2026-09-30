<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BetweenCondition implements BetweenConditionInterface
{
    private ?string $aggregation = null;
    private ?bool $changesOnly = null;
    private ?OperandInterface $end;
    private ?OperandInterface $start;
    private ?OperandInterface $value;

    public function __construct(?OperandInterface $value, ?OperandInterface $start, ?OperandInterface $end)
    {
        $this->value = $value;
        $this->start = $start;
        $this->end = $end;
    }

    public function getAggregation(): ?string
    {
        return $this->aggregation;
    }

    public function getChangesOnly(): ?bool
    {
        return $this->changesOnly;
    }

    public function getEnd(): ?OperandInterface
    {
        return $this->end;
    }

    public function getStart(): ?OperandInterface
    {
        return $this->start;
    }

    public function getValue(): ?OperandInterface
    {
        return $this->value;
    }

    public function setAggregation(?string $value): BetweenConditionInterface
    {
        $this->aggregation = $value;

        return $this;
    }

    public function setChangesOnly(?bool $value): BetweenConditionInterface
    {
        $this->changesOnly = $value;

        return $this;
    }
}
