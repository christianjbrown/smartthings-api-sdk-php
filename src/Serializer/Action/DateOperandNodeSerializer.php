<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\DateOperandInterface;

use function array_filter;

/**
 * Serializes DateOperandInterface into its JSON body.
 */
final class DateOperandNodeSerializer implements DateOperandNodeSerializerInterface
{
    /**
     * @param DateOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_TIME_ZONE_ID => $value->getTimeZoneId(),
            self::KEY_DAYS_OF_WEEK => $value->getDaysOfWeek(),
            self::KEY_YEAR => $value->getYear(),
            self::KEY_MONTH => $value->getMonth(),
            self::KEY_DAY => $value->getDay(),
            self::KEY_REFERENCE => $value->getReference(),
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
}
