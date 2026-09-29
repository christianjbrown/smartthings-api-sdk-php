<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;

interface TextButtonButtonsItemTransformerInterface
{
    public const string KEY_KEY = 'key';
    public const string KEY_LABEL = 'label';
    public const string KEY_STATE = 'state';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextButtonButtonsItemInterface;
}
