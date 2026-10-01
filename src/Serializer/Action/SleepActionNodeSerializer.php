<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\SleepActionInterface;

use function array_filter;

/**
 * Serializes SleepActionInterface into its JSON body.
 */
final class SleepActionNodeSerializer implements SleepActionNodeSerializerInterface
{
    /**
     * @param SleepActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_DURATION => self::serializeOptionalInterval($value->getDuration(), $registry),
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
