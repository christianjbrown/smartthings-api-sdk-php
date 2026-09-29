<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceLocalizationRequestInterface;

interface PreferenceLocalizationRequestSerializerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_LABEL = 'label';
    public const string KEY_OPTIONS = 'options';
    public const string KEY_TAG = 'tag';

    /**
     * @return mixed[]
     */
    public function serialize(PreferenceLocalizationRequestInterface $request): array;
}
