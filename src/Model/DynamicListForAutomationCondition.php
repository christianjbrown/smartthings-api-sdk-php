<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DynamicListForAutomationCondition implements DynamicListForAutomationConditionInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?bool $multiSelectable = null;
    private SupportedValuesForDynamicListInterface $supportedValues;
    private string $value;
    private ?string $valueType = null;

    public function __construct(string $value, SupportedValuesForDynamicListInterface $supportedValues)
    {
        $this->value = $value;
        $this->supportedValues = $supportedValues;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getMultiSelectable(): ?bool
    {
        return $this->multiSelectable;
    }

    public function getSupportedValues(): SupportedValuesForDynamicListInterface
    {
        return $this->supportedValues;
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
    public function setAlternatives(?array $value): DynamicListForAutomationConditionInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setMultiSelectable(?bool $value): DynamicListForAutomationConditionInterface
    {
        $this->multiSelectable = $value;

        return $this;
    }

    public function setValueType(?string $value): DynamicListForAutomationConditionInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
