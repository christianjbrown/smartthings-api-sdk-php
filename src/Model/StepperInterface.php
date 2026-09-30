<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StepperInterface
{
    public function getCommand(): ?StepperWithAvailableSizeCommandInterface;

    /**
     * @return mixed[]
     */
    public function getRange(): array;

    public function getStep(): ?float;

    public function getSupportedValues(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    public function setSupportedValues(?string $value): self;

    public function setValue(?string $value): self;

    public function setValueType(?string $value): self;
}
