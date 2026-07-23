<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;

interface LocaleReferenceTransformerInterface
{
    public const string KEY_TAG = 'tag';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocaleReferenceInterface;
}
