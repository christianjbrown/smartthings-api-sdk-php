<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\ConditionInterface;
use ChristianBrown\SmartThings\Model\EqualsConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\LessThanConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Model\RemainsConditionInterface;

use function array_filter;
use function array_map;

/**
 * Serializes RemainsConditionInterface into its JSON body.
 */
final class RemainsConditionNodeSerializer implements RemainsConditionNodeSerializerInterface
{
    /**
     * @param RemainsConditionInterface $value
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
            self::KEY_ID => $value->getId(),
            self::KEY_OPERAND => self::serializeOptionalOperand($value->getOperand(), $registry),
            self::KEY_DURATION => self::serializeOptionalInterval($value->getDuration(), $registry),
            self::KEY_LATCHING => $value->getLatching(),
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
    private static function serializeOptionalInterval(?IntervalInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(IntervalInterface::class)->serialize($value, $registry);
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
    private static function serializeOptionalOperand(?OperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(OperandInterface::class)->serialize($value, $registry);
    }
}
