<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\IfActionInterface;
use ChristianBrown\SmartThings\Model\LimitActionInterface;
use ChristianBrown\SmartThings\Model\LocationActionInterface;
use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SleepActionInterface;
use ChristianBrown\SmartThings\Model\ToggleActionInterface;

use function array_filter;

/**
 * Serializes ActionInterface into its JSON body.
 */
final class ActionNodeSerializer implements ActionNodeSerializerInterface
{
    /**
     * @param ActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_IF => self::serializeOptionalIfAction($value->getIf(), $registry),
            self::KEY_SLEEP => self::serializeOptionalSleepAction($value->getSleep(), $registry),
            self::KEY_COMMAND => self::serializeOptionalCommandAction($value->getCommand(), $registry),
            self::KEY_SCENE => self::serializeOptionalSceneAction($value->getScene(), $registry),
            self::KEY_EVERY => self::serializeOptionalEveryAction($value->getEvery(), $registry),
            self::KEY_LOCATION => self::serializeOptionalLocationAction($value->getLocation(), $registry),
            self::KEY_LIMIT => self::serializeOptionalLimitAction($value->getLimit(), $registry),
            self::KEY_TOGGLE => self::serializeOptionalToggleAction($value->getToggle(), $registry),
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
    private static function serializeOptionalCommandAction(?CommandActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(CommandActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalEveryAction(?EveryActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(EveryActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalIfAction(?IfActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(IfActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLimitAction(?LimitActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(LimitActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLocationAction(?LocationActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(LocationActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneAction(?SceneActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SceneActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSleepAction(?SleepActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(SleepActionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalToggleAction(?ToggleActionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(ToggleActionInterface::class)->serialize($value, $registry);
    }
}
