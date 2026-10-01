<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;

use function array_filter;
use function array_map;

/**
 * Serializes SceneCapabilityInterface into its JSON body.
 */
final class SceneCapabilityNodeSerializer implements SceneCapabilityNodeSerializerInterface
{
    /**
     * @param SceneCapabilityInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_CAPABILITY_ID => $value->getCapabilityId(),
            self::KEY_STATUS => $value->getStatus(),
            self::KEY_COMMANDS => self::serializeSceneCommandMap($value->getCommands(), $registry),
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
     * @param null|array<array-key, SceneCommandInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeSceneCommandMap(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneCommandInterface $item): array => $registry->get(SceneCommandInterface::class)->serialize($item, $registry), $values);
    }
}
