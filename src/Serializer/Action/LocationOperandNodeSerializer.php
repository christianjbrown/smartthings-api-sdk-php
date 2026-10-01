<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\LocationOperandInterface;

use function array_filter;

/**
 * Serializes LocationOperandInterface into its JSON body.
 */
final class LocationOperandNodeSerializer implements LocationOperandNodeSerializerInterface
{
    /**
     * @param LocationOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_POSTAL_CODE => $value->getPostalCode(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
            self::KEY_TRIGGER => $value->getTrigger(),
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
