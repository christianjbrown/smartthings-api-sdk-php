<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceCommandInterface;

interface DeviceCommandSerializerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMMAND_ID = 'commandId';
    public const string KEY_COMPONENT = 'component';

    /**
     * @param array<int, DeviceCommandInterface> $commands
     *
     * @return array<int, mixed[]>
     */
    public function serialize(array $commands): array;
}
