<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SliderForLightInterface;

interface SliderForLightSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_LABEL = 'label';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(SliderForLightInterface $model): array;
}
