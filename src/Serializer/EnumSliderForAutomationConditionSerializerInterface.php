<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;

interface EnumSliderForAutomationConditionSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_SUPPORTED_OPERATORS = 'supportedOperators';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(EnumSliderForAutomationConditionInterface $model): array;
}
