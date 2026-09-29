<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class VisibleConditionBase implements VisibleConditionBaseInterface
{
    private string $operand;
    private string $operator;
    private string $value;
    private ?string $valueType = null;

    public function __construct(string $value, string $operator, string $operand)
    {
        $this->value = $value;
        $this->operator = $operator;
        $this->operand = $operand;
    }

    public function getOperand(): string
    {
        return $this->operand;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function setValueType(?string $value): VisibleConditionBaseInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
