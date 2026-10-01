<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;

use function array_filter;

/**
 * Serializes TimeOperandInterface into its JSON body.
 */
final class TimeOperandNodeSerializer implements TimeOperandNodeSerializerInterface
{
    /**
     * @param TimeOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_TIME_ZONE_ID => $value->getTimeZoneId(),
            self::KEY_DAYS_OF_WEEK => $value->getDaysOfWeek(),
            self::KEY_REFERENCE => $value->getReference(),
            self::KEY_OFFSET => self::serializeOptionalInterval($value->getOffset(), $registry),
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
    private static function serializeOptionalInterval(?IntervalInterface $value, NodeSerializerRegistryInterface $registry): ?array
    {
        if (null === $value) {
            return null;
        }

        return $registry->get(IntervalInterface::class)->serialize($value, $registry);
    }
}
