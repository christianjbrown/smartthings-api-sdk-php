<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityInterface;

interface CapabilityTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_ATTRIBUTES, self::KEY_COMMANDS];
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_EPHEMERAL = 'ephemeral';
    public const string KEY_ID = 'id';
    public const string KEY_NAME = 'name';
    public const string KEY_STATUS = 'status';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityInterface;
}
