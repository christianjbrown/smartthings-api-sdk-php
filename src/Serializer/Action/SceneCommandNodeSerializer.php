<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneArgumentInterface;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;

use function array_filter;
use function array_map;

/**
 * Serializes SceneCommandInterface into its JSON body.
 */
final class SceneCommandNodeSerializer implements SceneCommandNodeSerializerInterface
{
    /**
     * @param SceneCommandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_ARGUMENTS => self::serializeSceneArgumentList($value->getArguments(), $registry),
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
     * @param null|array<int, SceneArgumentInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSceneArgumentList(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneArgumentInterface $item): array => $registry->get(SceneArgumentInterface::class)->serialize($item, $registry), $values);
    }
}
