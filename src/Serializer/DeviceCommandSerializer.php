<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceCommandInterface;

use function array_filter;
use function array_map;

final class DeviceCommandSerializer implements DeviceCommandSerializerInterface
{
    /**
     * @param array<int, DeviceCommandInterface> $commands
     *
     * @return array<int, mixed[]>
     */
    public function serialize(array $commands): array
    {
        return array_map(static fn (DeviceCommandInterface $command): array => self::serializeOne($command), $commands);
    }

    /**
     * @return mixed[]
     */
    private static function serializeOne(DeviceCommandInterface $command): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $command->getCapability(),
            self::KEY_COMMAND => $command->getCommand(),
            self::KEY_COMPONENT => $command->getComponent(),
            self::KEY_COMMAND_ID => $command->getCommandId(),
            self::KEY_ARGUMENTS => $command->getArguments(),
        ];

        // Omit null optionals rather than sending them as explicit nulls, so the
        // API applies its own defaults (e.g. "main" for an unset component).
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value && [] !== $value);
    }
}
