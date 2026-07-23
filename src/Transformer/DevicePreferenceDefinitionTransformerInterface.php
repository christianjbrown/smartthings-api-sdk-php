<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;

interface DevicePreferenceDefinitionTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_NAME = 'name';
    public const string KEY_PREFERENCE_ID = 'preferenceId';
    public const string KEY_PREFERENCE_TYPE = 'preferenceType';
    public const string KEY_REQUIRED = 'required';
    public const string KEY_TITLE = 'title';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DevicePreferenceDefinitionInterface;
}
