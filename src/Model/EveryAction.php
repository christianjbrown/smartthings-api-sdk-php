<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EveryAction implements EveryActionInterface
{
    /**
     * @var array<int, ActionInterface>
     */
    private array $actions;
    private ?IntervalInterface $interval = null;
    private ?ActionSequenceInterface $sequence = null;
    private ?DateTimeOperandInterface $specific = null;

    /**
     * @phpstan-param array<int, ActionInterface> $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return array<int, ActionInterface>
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getInterval(): ?IntervalInterface
    {
        return $this->interval;
    }

    public function getSequence(): ?ActionSequenceInterface
    {
        return $this->sequence;
    }

    public function getSpecific(): ?DateTimeOperandInterface
    {
        return $this->specific;
    }

    public function setInterval(?IntervalInterface $value): EveryActionInterface
    {
        $this->interval = $value;

        return $this;
    }

    public function setSequence(?ActionSequenceInterface $value): EveryActionInterface
    {
        $this->sequence = $value;

        return $this;
    }

    public function setSpecific(?DateTimeOperandInterface $value): EveryActionInterface
    {
        $this->specific = $value;

        return $this;
    }
}
