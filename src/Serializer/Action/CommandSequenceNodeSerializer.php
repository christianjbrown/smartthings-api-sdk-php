<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\CommandSequenceInterface;

use function array_filter;

/**
 * Serializes CommandSequenceInterface into its JSON body.
 */
final class CommandSequenceNodeSerializer implements CommandSequenceNodeSerializerInterface
{
    /**
     * @param CommandSequenceInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_COMMANDS => $value->getCommands(),
            self::KEY_DEVICES => $value->getDevices(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
