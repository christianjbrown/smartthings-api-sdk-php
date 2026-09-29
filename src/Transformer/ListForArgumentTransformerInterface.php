<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ListForArgumentInterface;

interface ListForArgumentTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ListForArgumentInterface;
}
