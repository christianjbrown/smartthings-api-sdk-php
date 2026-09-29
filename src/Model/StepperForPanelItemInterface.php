<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StepperForPanelItemInterface
{
    public function getCommand(): StepperForPanelItemCommandInterface;

    /**
     * @return mixed[]
     */
    public function getRange(): array;

    public function getSize(): string;

    public function getState(): StepperForPanelItemStateInterface;

    public function getStep(): float;

    public function getSupportedValues(): ?string;

    public function setSupportedValues(?string $value): self;
}
