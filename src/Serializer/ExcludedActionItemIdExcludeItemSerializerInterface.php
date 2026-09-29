<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;

interface ExcludedActionItemIdExcludeItemSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_VERSION = 'version';

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedActionItemIdExcludeItemInterface $model): array;
}
