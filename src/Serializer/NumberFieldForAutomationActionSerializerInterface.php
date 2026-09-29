<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\NumberFieldForAutomationActionInterface;

interface NumberFieldForAutomationActionSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_COMMAND = 'command';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_RANGE = 'range';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_UNIT = 'unit';

    /**
     * @return mixed[]
     */
    public function serialize(NumberFieldForAutomationActionInterface $model): array;
}
