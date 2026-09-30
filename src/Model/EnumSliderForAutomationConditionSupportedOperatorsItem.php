<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EnumSliderForAutomationConditionSupportedOperatorsItem implements EnumSliderForAutomationConditionSupportedOperatorsItemInterface
{
    private ?string $label;
    private ?string $operator;

    public function __construct(?string $operator, ?string $label)
    {
        $this->operator = $operator;
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }
}
