<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ListForAutomationConditionInterface;

interface ListForAutomationConditionTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_MULTI_SELECTABLE = 'multiSelectable';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ListForAutomationConditionInterface;
}
