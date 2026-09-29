<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Condition implements ConditionInterface
{
    /**
     * @var null|array<int, ConditionInterface>
     */
    private ?array $and = null;
    private ?BetweenConditionInterface $between = null;
    private ?ChangesConditionInterface $changes = null;
    private ?EqualsConditionInterface $equals = null;
    private ?GreaterThanConditionInterface $greaterThan = null;
    private ?GreaterThanOrEqualsConditionInterface $greaterThanOrEquals = null;
    private ?LessThanConditionInterface $lessThan = null;
    private ?LessThanOrEqualsConditionInterface $lessThanOrEquals = null;
    private ?ConditionInterface $not = null;

    /**
     * @var null|array<int, ConditionInterface>
     */
    private ?array $or = null;
    private ?RemainsConditionInterface $remains = null;
    private ?WasConditionInterface $was = null;

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

    public function getChanges(): ?ChangesConditionInterface
    {
        return $this->changes;
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

    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getOr(): ?array
    {
        return $this->or;
    }

    public function getRemains(): ?RemainsConditionInterface
    {
        return $this->remains;
    }

    public function getWas(): ?WasConditionInterface
    {
        return $this->was;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setAnd(?array $value): ConditionInterface
    {
        $this->and = $value;

        return $this;
    }

    public function setBetween(?BetweenConditionInterface $value): ConditionInterface
    {
        $this->between = $value;

        return $this;
    }

    public function setChanges(?ChangesConditionInterface $value): ConditionInterface
    {
        $this->changes = $value;

        return $this;
    }

    public function setEquals(?EqualsConditionInterface $value): ConditionInterface
    {
        $this->equals = $value;

        return $this;
    }

    public function setGreaterThan(?GreaterThanConditionInterface $value): ConditionInterface
    {
        $this->greaterThan = $value;

        return $this;
    }

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): ConditionInterface
    {
        $this->greaterThanOrEquals = $value;

        return $this;
    }

    public function setLessThan(?LessThanConditionInterface $value): ConditionInterface
    {
        $this->lessThan = $value;

        return $this;
    }

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): ConditionInterface
    {
        $this->lessThanOrEquals = $value;

        return $this;
    }

    public function setNot(?ConditionInterface $value): ConditionInterface
    {
        $this->not = $value;

        return $this;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): ConditionInterface
    {
        $this->or = $value;

        return $this;
    }

    public function setRemains(?RemainsConditionInterface $value): ConditionInterface
    {
        $this->remains = $value;

        return $this;
    }

    public function setWas(?WasConditionInterface $value): ConditionInterface
    {
        $this->was = $value;

        return $this;
    }
}
