<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class NumberFieldForAutomationCondition implements NumberFieldForAutomationConditionInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $description = null;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;
    private ?string $value;
    private ?string $valueType = null;

    public function __construct(?string $value)
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
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
    public function setAlternatives(?array $value): NumberFieldForAutomationConditionInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setDescription(?string $value): NumberFieldForAutomationConditionInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): NumberFieldForAutomationConditionInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): NumberFieldForAutomationConditionInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): NumberFieldForAutomationConditionInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValueType(?string $value): NumberFieldForAutomationConditionInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
