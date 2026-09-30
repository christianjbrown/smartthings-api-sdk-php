<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StepperForPanelItem implements StepperForPanelItemInterface
{
    private ?StepperForPanelItemCommandInterface $command;

    /**
     * @var mixed[]
     */
    private array $range;
    private ?string $size;
    private ?StepperForPanelItemStateInterface $state;
    private ?float $step;
    private ?string $supportedValues = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(?StepperForPanelItemCommandInterface $command, ?float $step, array $range, ?StepperForPanelItemStateInterface $state, ?string $size)
    {
        $this->command = $command;
        $this->step = $step;
        $this->range = $range;
        $this->state = $state;
        $this->size = $size;
    }

    public function getCommand(): ?StepperForPanelItemCommandInterface
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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getState(): ?StepperForPanelItemStateInterface
    {
        return $this->state;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function setSupportedValues(?string $value): StepperForPanelItemInterface
    {
        $this->supportedValues = $value;

        return $this;
    }
}
