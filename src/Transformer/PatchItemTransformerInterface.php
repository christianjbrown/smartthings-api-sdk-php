<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PatchItemInterface;

interface PatchItemTransformerInterface
{
    public const string KEY_OP = 'op';
    public const string KEY_PATH = 'path';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PatchItemInterface;
}
