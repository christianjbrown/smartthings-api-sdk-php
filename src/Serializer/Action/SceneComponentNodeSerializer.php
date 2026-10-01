<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneComponentInterface;

use function array_filter;
use function array_map;

/**
 * Serializes SceneComponentInterface into its JSON body.
 */
final class SceneComponentNodeSerializer implements SceneComponentNodeSerializerInterface
{
    /**
     * @param SceneComponentInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_COMPONENT_ID => $value->getComponentId(),
            self::KEY_CAPABILITIES => self::serializeSceneCapabilityList($value->getCapabilities(), $registry),
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
     * @param null|array<int, SceneCapabilityInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSceneCapabilityList(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneCapabilityInterface $item): array => $registry->get(SceneCapabilityInterface::class)->serialize($item, $registry), $values);
    }
}
