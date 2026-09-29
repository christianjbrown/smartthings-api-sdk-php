<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateCapabilityRequestInterface;

interface CreateCapabilityRequestSerializerInterface
{
    public const string KEY_ADDITIONAL_KEYWORDS = 'additionalKeywords';
    public const string KEY_ADDITIONAL_PROPERTIES = 'additionalProperties';
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_DATA = 'data';
    public const string KEY_DEFAULT = 'default';
    public const string KEY_ENUM = 'enum';
    public const string KEY_ENUM_COMMANDS = 'enumCommands';
    public const string KEY_EPHEMERAL = 'ephemeral';
    public const string KEY_NAME = 'name';
    public const string KEY_OPTIONAL = 'optional';
    public const string KEY_PROPERTIES = 'properties';
    public const string KEY_REQUIRED = 'required';
    public const string KEY_SCHEMA = 'schema';
    public const string KEY_SENSITIVE = 'sensitive';
    public const string KEY_SETTER = 'setter';
    public const string KEY_TITLE = 'title';
    public const string KEY_TYPE = 'type';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(CreateCapabilityRequestInterface $request): array;
}
