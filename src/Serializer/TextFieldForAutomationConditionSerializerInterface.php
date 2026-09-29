<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;

interface TextFieldForAutomationConditionSerializerInterface
{
    public const string KEY_RANGE = 'range';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';

    /**
     * @return mixed[]
     */
    public function serialize(TextFieldForAutomationConditionInterface $model): array;
}
