<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\LocationActionInterface;

use function array_filter;

/**
 * Serializes LocationActionInterface into its JSON body.
 */
final class LocationActionNodeSerializer implements LocationActionNodeSerializerInterface
{
    /**
     * @param LocationActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_MODE => $value->getMode(),
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
