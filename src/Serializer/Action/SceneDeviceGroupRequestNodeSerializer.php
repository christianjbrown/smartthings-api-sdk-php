<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;

use function array_filter;

/**
 * Serializes SceneDeviceGroupRequestInterface into its JSON body.
 */
final class SceneDeviceGroupRequestNodeSerializer implements SceneDeviceGroupRequestNodeSerializerInterface
{
    /**
     * @param SceneDeviceGroupRequestInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_DEVICE_GROUP_ID => $value->getDeviceGroupId(),
            self::KEY_ACTION_ID => $value->getActionId(),
            self::KEY_CAPABILITY => self::serializeOptionalSceneCapability($value->getCapability(), $registry),
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
    private static function serializeOptionalSceneCapability(?SceneCapabilityInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SceneCapabilityInterface::class)->serialize($value, $registry);
    }
}
