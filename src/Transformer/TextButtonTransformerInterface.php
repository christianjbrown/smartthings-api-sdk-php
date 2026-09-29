<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TextButtonInterface;

interface TextButtonTransformerInterface
{
    public const string KEY_BUTTONS = 'buttons';
    public const string KEY_COMMAND = 'command';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextButtonInterface;
}
