<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Stepper implements StepperInterface
{
    private ?StepperWithAvailableSizeCommandInterface $command;

    /**
     * @var mixed[]
     */
    private array $range;
    private ?float $step;
    private ?string $supportedValues = null;
    private ?string $value = null;
    private ?string $valueType = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(?StepperWithAvailableSizeCommandInterface $command, ?float $step, array $range)
    {
        $this->command = $command;
        $this->step = $step;
        $this->range = $range;
    }

    public function getCommand(): ?StepperWithAvailableSizeCommandInterface
    {
        return $this->command;
    }

    /**
     * @return mixed[]
     */
    public function getRange(): array
    {
        return $this->range;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function setSupportedValues(?string $value): StepperInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setValue(?string $value): StepperInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setValueType(?string $value): StepperInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
