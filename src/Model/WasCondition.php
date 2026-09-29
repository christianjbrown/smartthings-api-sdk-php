<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class WasCondition implements WasConditionInterface
{
    /**
     * @var null|array<int, ConditionInterface>
     */
    private ?array $and = null;
    private ?BetweenConditionInterface $between = null;
    private IntervalInterface $duration;
    private ?EqualsConditionInterface $equals = null;
    private ?GreaterThanConditionInterface $greaterThan = null;
    private ?GreaterThanOrEqualsConditionInterface $greaterThanOrEquals = null;
    private string $id;
    private ?LessThanConditionInterface $lessThan = null;
    private ?LessThanOrEqualsConditionInterface $lessThanOrEquals = null;
    private ?ConditionInterface $not = null;
    private ?OperandInterface $operand = null;

    /**
     * @var null|array<int, ConditionInterface>
     */
    private ?array $or = null;

    public function __construct(string $id, IntervalInterface $duration)
    {
        $this->id = $id;
        $this->duration = $duration;
    }

    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getAnd(): ?array
    {
        return $this->and;
    }

    public function getBetween(): ?BetweenConditionInterface
    {
        return $this->between;
    }

    public function getDuration(): IntervalInterface
    {
        return $this->duration;
    }

    public function getEquals(): ?EqualsConditionInterface
    {
        return $this->equals;
    }

    public function getGreaterThan(): ?GreaterThanConditionInterface
    {
        return $this->greaterThan;
    }

    public function getGreaterThanOrEquals(): ?GreaterThanOrEqualsConditionInterface
    {
        return $this->greaterThanOrEquals;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLessThan(): ?LessThanConditionInterface
    {
        return $this->lessThan;
    }

    public function getLessThanOrEquals(): ?LessThanOrEqualsConditionInterface
    {
        return $this->lessThanOrEquals;
    }

    public function getNot(): ?ConditionInterface
    {
        return $this->not;
    }

    public function getOperand(): ?OperandInterface
    {
        return $this->operand;
    }

    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getOr(): ?array
    {
        return $this->or;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setAnd(?array $value): WasConditionInterface
    {
        $this->and = $value;

        return $this;
    }

    public function setBetween(?BetweenConditionInterface $value): WasConditionInterface
    {
        $this->between = $value;

        return $this;
    }

    public function setEquals(?EqualsConditionInterface $value): WasConditionInterface
    {
        $this->equals = $value;

        return $this;
    }

    public function setGreaterThan(?GreaterThanConditionInterface $value): WasConditionInterface
    {
        $this->greaterThan = $value;

        return $this;
    }

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): WasConditionInterface
    {
        $this->greaterThanOrEquals = $value;

        return $this;
    }

    public function setLessThan(?LessThanConditionInterface $value): WasConditionInterface
    {
        $this->lessThan = $value;

        return $this;
    }

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): WasConditionInterface
    {
        $this->lessThanOrEquals = $value;

        return $this;
    }

    public function setNot(?ConditionInterface $value): WasConditionInterface
    {
        $this->not = $value;

        return $this;
    }

    public function setOperand(?OperandInterface $value): WasConditionInterface
    {
        $this->operand = $value;

        return $this;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): WasConditionInterface
    {
        $this->or = $value;

        return $this;
    }
}
