<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StepperWithAvailableSizeInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array;

    public function getCommand(): StepperWithAvailableSizeCommandInterface;

    /**
     * @return mixed[]
     */
    public function getRange(): array;

    public function getState(): StepperWithAvailableSizeStateInterface;

    public function getStep(): float;

    public function getSupportedValues(): ?string;

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): self;

    public function setSupportedValues(?string $value): self;
}
