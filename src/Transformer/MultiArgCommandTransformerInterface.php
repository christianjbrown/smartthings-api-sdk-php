<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;

interface MultiArgCommandTransformerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_COMMAND = 'command';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MultiArgCommandInterface;
}
