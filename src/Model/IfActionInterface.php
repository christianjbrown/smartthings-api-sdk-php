<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IfActionInterface
{
    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getAnd(): ?array;

    public function getBetween(): ?BetweenConditionInterface;

    public function getChanges(): ?ChangesConditionInterface;

    /**
     * @return null|array<int, ActionInterface>
     */
    public function getElse(): ?array;

    public function getEquals(): ?EqualsConditionInterface;

    public function getGreaterThan(): ?GreaterThanConditionInterface;

    public function getGreaterThanOrEquals(): ?GreaterThanOrEqualsConditionInterface;

    public function getLessThan(): ?LessThanConditionInterface;

    public function getLessThanOrEquals(): ?LessThanOrEqualsConditionInterface;

    public function getNot(): ?ConditionInterface;

    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getOr(): ?array;

    public function getRemains(): ?RemainsConditionInterface;

    public function getSequence(): ?IfActionSequenceInterface;

    /**
     * @return null|array<int, ActionInterface>
     */
    public function getThen(): ?array;

    public function getWas(): ?WasConditionInterface;

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setAnd(?array $value): self;

    public function setBetween(?BetweenConditionInterface $value): self;

    public function setChanges(?ChangesConditionInterface $value): self;

    /**
     * @param null|array<int, ActionInterface> $value
     */
    public function setElse(?array $value): self;

    public function setEquals(?EqualsConditionInterface $value): self;

    public function setGreaterThan(?GreaterThanConditionInterface $value): self;

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): self;

    public function setLessThan(?LessThanConditionInterface $value): self;

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): self;

    public function setNot(?ConditionInterface $value): self;

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): self;

    public function setRemains(?RemainsConditionInterface $value): self;

    public function setSequence(?IfActionSequenceInterface $value): self;

    /**
     * @param null|array<int, ActionInterface> $value
     */
    public function setThen(?array $value): self;

    public function setWas(?WasConditionInterface $value): self;
}
