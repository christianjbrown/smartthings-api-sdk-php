<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EnumSliderForAutomationCondition implements EnumSliderForAutomationConditionInterface
{
    /**
     * @var array<int, AlternativeItemInterface>
     */
    private array $alternatives;

    /**
     * @var null|array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface>
     */
    private ?array $supportedOperators = null;
    private ?string $value;

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

    /**
     * @return null|array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface>
     */
    public function getSupportedOperators(): ?array
    {
        return $this->supportedOperators;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param null|array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface> $value
     */
    public function setSupportedOperators(?array $value): EnumSliderForAutomationConditionInterface
    {
        $this->supportedOperators = $value;

        return $this;
    }
}
