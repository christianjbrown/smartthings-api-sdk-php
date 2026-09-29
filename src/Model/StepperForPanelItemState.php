<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StepperForPanelItemState implements StepperForPanelItemStateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $label = null;
    private ?string $unit = null;
    private string $value;
    private ?string $valueType = null;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getLabel(): ?string
    {
        return $this->label;
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
    public function setAlternatives(?array $value): StepperForPanelItemStateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setLabel(?string $value): StepperForPanelItemStateInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setUnit(?string $value): StepperForPanelItemStateInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValueType(?string $value): StepperForPanelItemStateInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
