<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;

interface NumberFieldForAutomationConditionTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_RANGE = 'range';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NumberFieldForAutomationConditionInterface;
}
