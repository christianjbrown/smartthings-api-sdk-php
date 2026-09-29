<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;

interface CapabilityConfigurationValueTransformerInterface
{
    public const string KEY_ENABLED_VALUES = 'enabledValues';
    public const string KEY_KEY = 'key';
    public const string KEY_RANGE = 'range';
    public const string KEY_STEP = 'step';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityConfigurationValueInterface;
}
