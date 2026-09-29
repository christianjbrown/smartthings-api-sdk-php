<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IfAction implements IfActionInterface
{
    /**
     * @var null|array<int, ConditionInterface>
     */
    private ?array $and = null;
    private ?BetweenConditionInterface $between = null;
    private ?ChangesConditionInterface $changes = null;

    /**
     * @var null|array<int, ActionInterface>
     */
    private ?array $else = null;
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
    private ?IfActionSequenceInterface $sequence = null;

    /**
     * @var null|array<int, ActionInterface>
     */
    private ?array $then = null;
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

    /**
     * @return null|array<int, ActionInterface>
     */
    public function getElse(): ?array
    {
        return $this->else;
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

    public function getSequence(): ?IfActionSequenceInterface
    {
        return $this->sequence;
    }

    /**
     * @return null|array<int, ActionInterface>
     */
    public function getThen(): ?array
    {
        return $this->then;
    }

    public function getWas(): ?WasConditionInterface
    {
        return $this->was;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setAnd(?array $value): IfActionInterface
    {
        $this->and = $value;

        return $this;
    }

    public function setBetween(?BetweenConditionInterface $value): IfActionInterface
    {
        $this->between = $value;

        return $this;
    }

    public function setChanges(?ChangesConditionInterface $value): IfActionInterface
    {
        $this->changes = $value;

        return $this;
    }

    /**
     * @param null|array<int, ActionInterface> $value
     */
    public function setElse(?array $value): IfActionInterface
    {
        $this->else = $value;

        return $this;
    }

    public function setEquals(?EqualsConditionInterface $value): IfActionInterface
    {
        $this->equals = $value;

        return $this;
    }

    public function setGreaterThan(?GreaterThanConditionInterface $value): IfActionInterface
    {
        $this->greaterThan = $value;

        return $this;
    }

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): IfActionInterface
    {
        $this->greaterThanOrEquals = $value;

        return $this;
    }

    public function setLessThan(?LessThanConditionInterface $value): IfActionInterface
    {
        $this->lessThan = $value;

        return $this;
    }

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): IfActionInterface
    {
        $this->lessThanOrEquals = $value;

        return $this;
    }

    public function setNot(?ConditionInterface $value): IfActionInterface
    {
        $this->not = $value;

        return $this;
    }

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): IfActionInterface
    {
        $this->or = $value;

        return $this;
    }

    public function setRemains(?RemainsConditionInterface $value): IfActionInterface
    {
        $this->remains = $value;

        return $this;
    }

    public function setSequence(?IfActionSequenceInterface $value): IfActionInterface
    {
        $this->sequence = $value;

        return $this;
    }

    /**
     * @param null|array<int, ActionInterface> $value
     */
    public function setThen(?array $value): IfActionInterface
    {
        $this->then = $value;

        return $this;
    }

    public function setWas(?WasConditionInterface $value): IfActionInterface
    {
        $this->was = $value;

        return $this;
    }
}
