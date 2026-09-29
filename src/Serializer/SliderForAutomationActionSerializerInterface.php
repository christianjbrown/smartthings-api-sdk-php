<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SliderForAutomationActionInterface;

interface SliderForAutomationActionSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_COMMAND = 'command';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_UNIT = 'unit';

    /**
     * @return mixed[]
     */
    public function serialize(SliderForAutomationActionInterface $model): array;
}
