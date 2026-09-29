<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceDefinitionInterface;

interface PreferenceDefinitionSerializerInterface
{
    public const string KEY_DEFAULT = 'default';
    public const string KEY_MAX_LENGTH = 'maxLength';
    public const string KEY_MAXIMUM = 'maximum';
    public const string KEY_MIN_LENGTH = 'minLength';
    public const string KEY_MINIMUM = 'minimum';
    public const string KEY_OPTIONS = 'options';
    public const string KEY_STRING_TYPE = 'stringType';

    /**
     * @return mixed[]
     */
    public function serialize(PreferenceDefinitionInterface $model): array;
}
