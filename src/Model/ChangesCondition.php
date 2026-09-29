<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ChangesCondition implements ChangesConditionInterface
{
    /**
     * @var null|array<int, ConditionInterface>
     */
    private ?array $and = null;
    private ?BetweenConditionInterface $between = null;
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

    public function __construct(string $id)
    {
        $this->id = $id;
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
    public function setAnd(?array $value): ChangesConditionInterface
    {
        $this->and = $value;

        return $this;
    }

    public function setBetween(?BetweenConditionInterface $value): ChangesConditionInterface
    {
        $this->between = $value;

        return $this;
    }

    public function setEquals(?EqualsConditionInterface $value): ChangesConditionInterface
    {
        $this->equals = $value;

        return $this;
    }

    public function setGreaterThan(?GreaterThanConditionInterface $value): ChangesConditionInterface
    {
        $this->greaterThan = $value;

        return $this;
    }

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): ChangesConditionInterface
    {
        $this->greaterThanOrEquals = $value;

        return $this;
    }

    public function setLessThan(?LessThanConditionInterface $value): ChangesConditionInterface
    {
        $this->lessThan = $value;

        return $this;
    }

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): ChangesConditionInterface
    {
        $this->lessThanOrEquals = $value;

        return $this;
    }

    public function setNot(?ConditionInterface $value): ChangesConditionInterface
    {
        $this->not = $value;

        return $this;
    }

    public function setOperand(?OperandInterface $value): ChangesConditionInterface
    {
        $this->operand = $value;

        return $this;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): ChangesConditionInterface
    {
        $this->or = $value;

        return $this;
    }
}
