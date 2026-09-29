<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandMappingInterface;

interface CommandMappingTransformerInterface
{
    public const string KEY_CAPABILITY_ID = 'capabilityId';
    public const string KEY_COMMAND = 'command';
    public const string KEY_EVENT_VALUES = 'eventValues';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_INT_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandMappingInterface;
}
