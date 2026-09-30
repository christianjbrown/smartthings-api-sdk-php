<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForAutomationCondition implements ListForAutomationConditionInterface
{
    /**
     * @var array<int, AlternativeItemInterface>
     */
    private array $alternatives;
    private ?bool $multiSelectable = null;
    private ?string $supportedValues = null;
    private ?string $value;
    private ?string $valueType = null;

    /**
     * @phpstan-param array<int, AlternativeItemInterface> $alternatives
     */
    public function __construct(array $alternatives, ?string $value)
    {
        $this->alternatives = $alternatives;
        $this->value = $value;
    }

    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array
    {
        return $this->alternatives;
    }

    public function getMultiSelectable(): ?bool
    {
        return $this->multiSelectable;
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

    public function setMultiSelectable(?bool $value): ListForAutomationConditionInterface
    {
        $this->multiSelectable = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): ListForAutomationConditionInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setValueType(?string $value): ListForAutomationConditionInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
