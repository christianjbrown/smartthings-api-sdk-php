<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SliderForAutomationCondition implements SliderForAutomationConditionInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;

    /**
     * @var mixed[]
     */
    private array $range;
    private ?float $step = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;
    private string $value;
    private ?string $valueType = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(array $range, string $value)
    {
        $this->range = $range;
        $this->value = $value;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
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

    public function getValue(): string
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
    public function setAlternatives(?array $value): SliderForAutomationConditionInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setStep(?float $value): SliderForAutomationConditionInterface
    {
        $this->step = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): SliderForAutomationConditionInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): SliderForAutomationConditionInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValueType(?string $value): SliderForAutomationConditionInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
