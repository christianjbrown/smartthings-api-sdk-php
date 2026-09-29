<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeInterface;

interface CapabilityAttributeTransformerInterface
{
    public const string KEY_ENUM_COMMANDS = 'enumCommands';
    public const string KEY_SCHEMA = 'schema';
    public const string KEY_SETTER = 'setter';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityAttributeInterface;
}
