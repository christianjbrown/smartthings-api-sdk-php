<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeInterface;

interface BasicPlusTvVolumeTransformerInterface
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
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvVolumeInterface;
}
