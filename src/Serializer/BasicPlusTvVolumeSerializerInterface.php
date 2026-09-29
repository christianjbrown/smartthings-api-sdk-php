<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeInterface;

interface BasicPlusTvVolumeSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_LABEL = 'label';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_VALUE = 'value';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvVolumeInterface $model): array;
}
