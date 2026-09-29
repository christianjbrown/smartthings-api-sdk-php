<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ConditionInterface
{
    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getAnd(): ?array;

    public function getBetween(): ?BetweenConditionInterface;

    public function getChanges(): ?ChangesConditionInterface;

    public function getEquals(): ?EqualsConditionInterface;

    public function getGreaterThan(): ?GreaterThanConditionInterface;

    public function getGreaterThanOrEquals(): ?GreaterThanOrEqualsConditionInterface;

    public function getLessThan(): ?LessThanConditionInterface;

    public function getLessThanOrEquals(): ?LessThanOrEqualsConditionInterface;

    public function getNot(): ?self;

    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getOr(): ?array;

    public function getRemains(): ?RemainsConditionInterface;

    public function getWas(): ?WasConditionInterface;

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setAnd(?array $value): self;

    public function setBetween(?BetweenConditionInterface $value): self;

    public function setChanges(?ChangesConditionInterface $value): self;

    public function setEquals(?EqualsConditionInterface $value): self;

    public function setGreaterThan(?GreaterThanConditionInterface $value): self;

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): self;

    public function setLessThan(?LessThanConditionInterface $value): self;

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): self;

    public function setNot(?self $value): self;

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): self;

    public function setRemains(?RemainsConditionInterface $value): self;

    public function setWas(?WasConditionInterface $value): self;
}
