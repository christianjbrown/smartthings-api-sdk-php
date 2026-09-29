<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SliderWithAvailableSize implements SliderWithAvailableSizeInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $argumentType = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $availableSizes = null;
    private string $command;

    /**
     * @var mixed[]
     */
    private array $range;
    private ?float $step = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;
    private ?string $value = null;
    private ?string $valueType = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(array $range, string $command)
    {
        $this->range = $range;
        $this->command = $command;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array
    {
        return $this->availableSizes;
    }

    public function getCommand(): string
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): SliderWithAvailableSizeInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setArgumentType(?string $value): SliderWithAvailableSizeInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): SliderWithAvailableSizeInterface
    {
        $this->availableSizes = $value;

        return $this;
    }

    public function setStep(?float $value): SliderWithAvailableSizeInterface
    {
        $this->step = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): SliderWithAvailableSizeInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): SliderWithAvailableSizeInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValue(?string $value): SliderWithAvailableSizeInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setValueType(?string $value): SliderWithAvailableSizeInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
