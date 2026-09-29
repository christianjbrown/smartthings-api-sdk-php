<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EveryActionInterface
{
    /**
     * @return array<int, ActionInterface>
     */
    public function getActions(): array;

    public function getInterval(): ?IntervalInterface;

    public function getSequence(): ?ActionSequenceInterface;

    public function getSpecific(): ?DateTimeOperandInterface;

    public function setInterval(?IntervalInterface $value): self;

    public function setSequence(?ActionSequenceInterface $value): self;

    public function setSpecific(?DateTimeOperandInterface $value): self;
}
