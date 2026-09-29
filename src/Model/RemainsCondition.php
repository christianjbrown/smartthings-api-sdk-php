<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RemainsCondition implements RemainsConditionInterface
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
    private ?bool $latching = null;
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

    public function getLatching(): ?bool
    {
        return $this->latching;
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
    public function setAnd(?array $value): RemainsConditionInterface
    {
        $this->and = $value;

        return $this;
    }

    public function setBetween(?BetweenConditionInterface $value): RemainsConditionInterface
    {
        $this->between = $value;

        return $this;
    }

    public function setEquals(?EqualsConditionInterface $value): RemainsConditionInterface
    {
        $this->equals = $value;

        return $this;
    }

    public function setGreaterThan(?GreaterThanConditionInterface $value): RemainsConditionInterface
    {
        $this->greaterThan = $value;

        return $this;
    }

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): RemainsConditionInterface
    {
        $this->greaterThanOrEquals = $value;

        return $this;
    }

    public function setLatching(?bool $value): RemainsConditionInterface
    {
        $this->latching = $value;

        return $this;
    }

    public function setLessThan(?LessThanConditionInterface $value): RemainsConditionInterface
    {
        $this->lessThan = $value;

        return $this;
    }

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): RemainsConditionInterface
    {
        $this->lessThanOrEquals = $value;

        return $this;
    }

    public function setNot(?ConditionInterface $value): RemainsConditionInterface
    {
        $this->not = $value;

        return $this;
    }

    public function setOperand(?OperandInterface $value): RemainsConditionInterface
    {
        $this->operand = $value;

        return $this;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): RemainsConditionInterface
    {
        $this->or = $value;

        return $this;
    }
}
