<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;

interface DevicePreferenceTransformerInterface
{
    public const string KEY_NAME = 'name';
    public const string KEY_PREFERENCE_TYPE = 'preferenceType';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DevicePreferenceInterface;
}
