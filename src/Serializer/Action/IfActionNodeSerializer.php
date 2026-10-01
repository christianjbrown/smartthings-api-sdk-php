<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\ChangesConditionInterface;
use ChristianBrown\SmartThings\Model\ConditionInterface;
use ChristianBrown\SmartThings\Model\EqualsConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\IfActionInterface;
use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;
use ChristianBrown\SmartThings\Model\LessThanConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\RemainsConditionInterface;
use ChristianBrown\SmartThings\Model\WasConditionInterface;

use function array_filter;
use function array_map;

/**
 * Serializes IfActionInterface into its JSON body.
 */
final class IfActionNodeSerializer implements IfActionNodeSerializerInterface
{
    /**
     * @param IfActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_AND => self::serializeConditionList($value->getAnd(), $registry),
            self::KEY_OR => self::serializeConditionList($value->getOr(), $registry),
            self::KEY_NOT => self::serializeOptionalCondition($value->getNot(), $registry),
            self::KEY_EQUALS => self::serializeOptionalEqualsCondition($value->getEquals(), $registry),
            self::KEY_GREATER_THAN => self::serializeOptionalGreaterThanCondition($value->getGreaterThan(), $registry),
            self::KEY_GREATER_THAN_OR_EQUALS => self::serializeOptionalGreaterThanOrEqualsCondition($value->getGreaterThanOrEquals(), $registry),
            self::KEY_LESS_THAN => self::serializeOptionalLessThanCondition($value->getLessThan(), $registry),
            self::KEY_LESS_THAN_OR_EQUALS => self::serializeOptionalLessThanOrEqualsCondition($value->getLessThanOrEquals(), $registry),
            self::KEY_BETWEEN => self::serializeOptionalBetweenCondition($value->getBetween(), $registry),
            self::KEY_CHANGES => self::serializeOptionalChangesCondition($value->getChanges(), $registry),
            self::KEY_REMAINS => self::serializeOptionalRemainsCondition($value->getRemains(), $registry),
            self::KEY_WAS => self::serializeOptionalWasCondition($value->getWas(), $registry),
            self::KEY_THEN => self::serializeActionList($value->getThen(), $registry),
            self::KEY_ELSE => self::serializeActionList($value->getElse(), $registry),
            self::KEY_SEQUENCE => self::serializeOptionalIfActionSequence($value->getSequence(), $registry),
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
     * @param null|array<int, ActionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeActionList(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (ActionInterface $item): array => $registry->get(ActionInterface::class)->serialize($item, $registry), $values);
    }

    /**
     * @param null|array<int, ConditionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeConditionList(?array $values, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (ConditionInterface $item): array => $registry->get(ConditionInterface::class)->serialize($item, $registry), $values);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalBetweenCondition(?BetweenConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(BetweenConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalChangesCondition(?ChangesConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(ChangesConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCondition(?ConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(ConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalEqualsCondition(?EqualsConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(EqualsConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalGreaterThanCondition(?GreaterThanConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(GreaterThanConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalGreaterThanOrEqualsCondition(?GreaterThanOrEqualsConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(GreaterThanOrEqualsConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalIfActionSequence(?IfActionSequenceInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(IfActionSequenceInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLessThanCondition(?LessThanConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(LessThanConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLessThanOrEqualsCondition(?LessThanOrEqualsConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(LessThanOrEqualsConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalRemainsCondition(?RemainsConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(RemainsConditionInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalWasCondition(?WasConditionInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(WasConditionInterface::class)->serialize($value, $registry);
    }
}
