<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EnumSliderForAutomationConditionInterface
{
    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array;

    /**
     * @return null|array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface>
     */
    public function getSupportedOperators(): ?array;

    public function getValue(): ?string;

    /**
     * @param null|array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface> $value
     */
    public function setSupportedOperators(?array $value): self;
}
