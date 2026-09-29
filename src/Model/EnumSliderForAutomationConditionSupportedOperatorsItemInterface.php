<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EnumSliderForAutomationConditionSupportedOperatorsItemInterface
{
    public function getLabel(): string;

    public function getOperator(): string;
}
