<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;

use function array_filter;

/**
 * Serializes DateTimeOperandInterface into its JSON body.
 */
final class DateTimeOperandNodeSerializer implements DateTimeOperandNodeSerializerInterface
{
    /**
     * @param DateTimeOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_TIME_ZONE_ID => $value->getTimeZoneId(),
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_DAYS_OF_WEEK => $value->getDaysOfWeek(),
            self::KEY_YEAR => $value->getYear(),
            self::KEY_MONTH => $value->getMonth(),
            self::KEY_DAY => $value->getDay(),
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
