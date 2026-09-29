<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LanguageItemInterface;

interface LanguageItemTransformerInterface
{
    public const string KEY_LOCALE = 'locale';
    public const string KEY_PO_CODES = 'poCodes';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LanguageItemInterface;
}
