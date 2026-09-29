<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;

interface DeviceCategoryTransformerInterface
{
    public const string KEY_CATEGORY_TYPE = 'categoryType';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceCategoryInterface;
}
