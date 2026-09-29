<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;

interface EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface
{
    public const string KEY_LABEL = 'label';
    public const string KEY_OPERATOR = 'operator';

    /**
     * @return mixed[]
     */
    public function serialize(EnumSliderForAutomationConditionSupportedOperatorsItemInterface $model): array;
}
