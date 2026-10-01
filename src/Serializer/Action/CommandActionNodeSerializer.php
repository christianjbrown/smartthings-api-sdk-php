<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;
use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;

use function array_filter;
use function array_map;

/**
 * Serializes CommandActionInterface into its JSON body.
 */
final class CommandActionNodeSerializer implements CommandActionNodeSerializerInterface
{
    /**
     * @param CommandActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_DEVICES => $value->getDevices(),
            self::KEY_COMMANDS => self::serializeRequiredRuleDeviceCommandList($value->getCommands(), $registry),
            self::KEY_SEQUENCE => self::serializeOptionalCommandSequence($value->getSequence(), $registry),
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

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCommandSequence(?CommandSequenceInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(CommandSequenceInterface::class)->serialize($value, $registry);
    }

    /**
     * @param array<int, RuleDeviceCommandInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredRuleDeviceCommandList(array $values, NodeSerializerRegistryInterface $registry): array
    {
        return array_map(static fn (RuleDeviceCommandInterface $item): array => $registry->get(RuleDeviceCommandInterface::class)->serialize($item, $registry), $values);
    }
}
