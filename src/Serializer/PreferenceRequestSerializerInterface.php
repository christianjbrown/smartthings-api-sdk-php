<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;

interface PreferenceRequestSerializerInterface
{
    public const string KEY_DEFINITION = 'definition';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_EXPLICIT = 'explicit';
    public const string KEY_NAME = 'name';
    public const string KEY_PREFERENCE_ID = 'preferenceId';
    public const string KEY_PREFERENCE_TYPE = 'preferenceType';
    public const string KEY_REQUIRED = 'required';
    public const string KEY_TITLE = 'title';

    /**
     * @return mixed[]
     */
    public function serialize(PreferenceRequestInterface $request): array;
}
