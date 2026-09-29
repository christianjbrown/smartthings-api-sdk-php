<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;

interface ExcludedDeviceConditionConfigEntryTransformerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_EXCLUSION = 'exclusion';
    public const string KEY_PATCH = 'patch';
    public const string KEY_VALUES = 'values';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedDeviceConditionConfigEntryInterface;
}
