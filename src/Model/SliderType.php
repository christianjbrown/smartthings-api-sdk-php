<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SliderType implements SliderTypeInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $argumentType = null;
    private ?string $command = null;

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
    public function __construct(array $range)
    {
        $this->range = $range;
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

    public function getCommand(): ?string
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
    public function setAlternatives(?array $value): SliderTypeInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setArgumentType(?string $value): SliderTypeInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setCommand(?string $value): SliderTypeInterface
    {
        $this->command = $value;

        return $this;
    }

    public function setStep(?float $value): SliderTypeInterface
    {
        $this->step = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): SliderTypeInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): SliderTypeInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValue(?string $value): SliderTypeInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setValueType(?string $value): SliderTypeInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
