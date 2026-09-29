<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandArgumentInterface;

interface CommandArgumentTransformerInterface
{
    public const string KEY_NAME = 'name';
    public const string KEY_OPTIONAL = 'optional';
    public const string KEY_SCHEMA = 'schema';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandArgumentInterface;
}
