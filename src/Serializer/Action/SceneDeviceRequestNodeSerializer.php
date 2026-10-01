<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneComponentInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;

use function array_filter;
use function array_map;

/**
 * Serializes SceneDeviceRequestInterface into its JSON body.
 */
final class SceneDeviceRequestNodeSerializer implements SceneDeviceRequestNodeSerializerInterface
{
    /**
     * @param SceneDeviceRequestInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_DEVICE_ID => $value->getDeviceId(),
            self::KEY_ACTION_ID => $value->getActionId(),
            self::KEY_COMPONENTS => self::serializeSceneComponentList($value->getComponents(), $registry),
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
     * @param null|array<int, SceneComponentInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSceneComponentList(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneComponentInterface $item): array => $registry->get(SceneComponentInterface::class)->serialize($item, $registry), $values);
    }
}
