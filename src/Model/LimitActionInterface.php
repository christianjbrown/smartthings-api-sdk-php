<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LimitActionInterface
{
    /**
     * @return array<int, ActionInterface>
     */
    public function getActions(): array;

    public function getCount(): int;

    public function getPeriod(): string;

    public function getSequence(): ?ActionSequenceInterface;

    public function setSequence(?ActionSequenceInterface $value): self;
}
