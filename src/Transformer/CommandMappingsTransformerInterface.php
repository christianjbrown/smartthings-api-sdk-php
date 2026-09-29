<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandMappingsInterface;

interface CommandMappingsTransformerInterface
{
    public const string KEY_COMMANDS = 'commands';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandMappingsInterface;
}
