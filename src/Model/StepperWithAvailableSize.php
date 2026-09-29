<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StepperWithAvailableSize implements StepperWithAvailableSizeInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $availableSizes = null;
    private StepperWithAvailableSizeCommandInterface $command;

    /**
     * @var mixed[]
     */
    private array $range;
    private StepperWithAvailableSizeStateInterface $state;
    private float $step;
    private ?string $supportedValues = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(StepperWithAvailableSizeCommandInterface $command, float $step, array $range, StepperWithAvailableSizeStateInterface $state)
    {
        $this->command = $command;
        $this->step = $step;
        $this->range = $range;
        $this->state = $state;
    }

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array
    {
        return $this->availableSizes;
    }

    public function getCommand(): StepperWithAvailableSizeCommandInterface
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

    public function getState(): StepperWithAvailableSizeStateInterface
    {
        return $this->state;
    }

    public function getStep(): float
    {
        return $this->step;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): StepperWithAvailableSizeInterface
    {
        $this->availableSizes = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): StepperWithAvailableSizeInterface
    {
        $this->supportedValues = $value;

        return $this;
    }
}
