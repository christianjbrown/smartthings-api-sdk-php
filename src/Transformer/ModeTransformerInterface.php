<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ModeInterface;

interface ModeTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_LABEL = 'label';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ModeInterface;
}
