<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LimitAction implements LimitActionInterface
{
    /**
     * @var array<int, ActionInterface>
     */
    private array $actions;
    private int $count;
    private string $period;
    private ?ActionSequenceInterface $sequence = null;

    /**
     * @phpstan-param array<int, ActionInterface> $actions
     */
    public function __construct(int $count, string $period, array $actions)
    {
        $this->count = $count;
        $this->period = $period;
        $this->actions = $actions;
    }

    /**
     * @return array<int, ActionInterface>
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function getSequence(): ?ActionSequenceInterface
    {
        return $this->sequence;
    }

    public function setSequence(?ActionSequenceInterface $value): LimitActionInterface
    {
        $this->sequence = $value;

        return $this;
    }
}
