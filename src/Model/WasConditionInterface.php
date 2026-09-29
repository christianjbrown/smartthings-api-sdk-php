<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface WasConditionInterface
{
    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getAnd(): ?array;

    public function getBetween(): ?BetweenConditionInterface;

    public function getDuration(): IntervalInterface;

    public function getEquals(): ?EqualsConditionInterface;

    public function getGreaterThan(): ?GreaterThanConditionInterface;

    public function getGreaterThanOrEquals(): ?GreaterThanOrEqualsConditionInterface;

    public function getId(): string;

    public function getLessThan(): ?LessThanConditionInterface;

    public function getLessThanOrEquals(): ?LessThanOrEqualsConditionInterface;

    public function getNot(): ?ConditionInterface;

    public function getOperand(): ?OperandInterface;

    /**
     * @return null|array<int, ConditionInterface>
     */
    public function getOr(): ?array;

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setAnd(?array $value): self;

    public function setBetween(?BetweenConditionInterface $value): self;

    public function setEquals(?EqualsConditionInterface $value): self;

    public function setGreaterThan(?GreaterThanConditionInterface $value): self;

    public function setGreaterThanOrEquals(?GreaterThanOrEqualsConditionInterface $value): self;

    public function setLessThan(?LessThanConditionInterface $value): self;

    public function setLessThanOrEquals(?LessThanOrEqualsConditionInterface $value): self;

    public function setNot(?ConditionInterface $value): self;

    public function setOperand(?OperandInterface $value): self;

    /**
     * @param null|array<int, ConditionInterface> $value
     */
    public function setOr(?array $value): self;
}
