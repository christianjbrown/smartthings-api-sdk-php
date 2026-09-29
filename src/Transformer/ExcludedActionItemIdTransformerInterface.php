<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;

interface ExcludedActionItemIdTransformerInterface
{
    public const string KEY_EXCLUDE = 'exclude';
    public const string KEY_ID = 'id';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedActionItemIdInterface;
}
