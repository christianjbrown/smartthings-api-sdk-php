<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StepperInterface;

interface StepperTransformerInterface
{
    public const string KEY_COMMAND = 'command';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_NUMBER_SPRINTF = '%s not set or not a number';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StepperInterface;
}
