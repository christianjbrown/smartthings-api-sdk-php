<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;

interface NumberFieldForAutomationConditionSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_RANGE = 'range';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';

    /**
     * @return mixed[]
     */
    public function serialize(NumberFieldForAutomationConditionInterface $model): array;
}
