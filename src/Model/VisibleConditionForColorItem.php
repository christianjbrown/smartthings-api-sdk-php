<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class VisibleConditionForColorItem implements VisibleConditionForColorItemInterface
{
    private string $operand;
    private string $operator;
    private ?VisibleConditionForColorItemReferToInterface $referTo = null;

    public function __construct(string $operator, string $operand)
    {
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

    public function getReferTo(): ?VisibleConditionForColorItemReferToInterface
    {
        return $this->referTo;
    }

    public function setReferTo(?VisibleConditionForColorItemReferToInterface $value): VisibleConditionForColorItemInterface
    {
        $this->referTo = $value;

        return $this;
    }
}
