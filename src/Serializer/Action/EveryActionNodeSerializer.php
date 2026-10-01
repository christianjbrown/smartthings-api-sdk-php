<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;

use function array_filter;
use function array_map;

/**
 * Serializes EveryActionInterface into its JSON body.
 */
final class EveryActionNodeSerializer implements EveryActionNodeSerializerInterface
{
    /**
     * @param EveryActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_INTERVAL => self::serializeOptionalInterval($value->getInterval(), $registry),
            self::KEY_SPECIFIC => self::serializeOptionalDateTimeOperand($value->getSpecific(), $registry),
            self::KEY_ACTIONS => self::serializeRequiredActionList($value->getActions(), $registry),
            self::KEY_SEQUENCE => self::serializeOptionalActionSequence($value->getSequence(), $registry),
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
    private static function serializeOptionalActionSequence(?ActionSequenceInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(ActionSequenceInterface::class)->serialize($value, $registry);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDateTimeOperand(?DateTimeOperandInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(DateTimeOperandInterface::class)->serialize($value, $registry);
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
     * @param array<int, ActionInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredActionList(array $values, NodeSerializerRegistryInterface $registry): array
    {
        return array_map(static fn (ActionInterface $item): array => $registry->get(ActionInterface::class)->serialize($item, $registry), $values);
    }
}
