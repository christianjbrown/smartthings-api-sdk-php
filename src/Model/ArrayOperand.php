<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ArrayOperand implements ArrayOperandInterface
{
    private ?string $aggregation = null;

    /**
     * @var array<int, OperandInterface>
     */
    private array $operands;

    /**
     * @phpstan-param array<int, OperandInterface> $operands
     */
    public function __construct(array $operands)
    {
        $this->operands = $operands;
    }

    public function getAggregation(): ?string
    {
        return $this->aggregation;
    }

    /**
     * @return array<int, OperandInterface>
     */
    public function getOperands(): array
    {
        return $this->operands;
    }

    public function setAggregation(?string $value): ArrayOperandInterface
    {
        $this->aggregation = $value;

        return $this;
    }
}
