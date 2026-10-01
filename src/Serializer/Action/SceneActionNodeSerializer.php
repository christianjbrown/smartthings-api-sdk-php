<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;
use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;
use ChristianBrown\SmartThings\Model\SceneSleepRequestInterface;

use function array_filter;

/**
 * Serializes SceneActionInterface into its JSON body.
 */
final class SceneActionNodeSerializer implements SceneActionNodeSerializerInterface
{
    /**
     * @param SceneActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_DEVICE_REQUEST => self::serializeOptionalSceneDeviceRequest($value->getDeviceRequest(), $registry),
            self::KEY_MODE_REQUEST => self::serializeOptionalSceneModeRequest($value->getModeRequest(), $registry),
            self::KEY_SLEEP_REQUEST => self::serializeOptionalSceneSleepRequest($value->getSleepRequest(), $registry),
            self::KEY_DEVICE_GROUP_REQUEST => self::serializeOptionalSceneDeviceGroupRequest($value->getDeviceGroupRequest(), $registry),
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
    private static function serializeOptionalSceneDeviceGroupRequest(?SceneDeviceGroupRequestInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SceneDeviceGroupRequestInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneDeviceRequest(?SceneDeviceRequestInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SceneDeviceRequestInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneModeRequest(?SceneModeRequestInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SceneModeRequestInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneSleepRequest(?SceneSleepRequestInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SceneSleepRequestInterface::class)->serialize($value, $registry);
    }
}
