<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CoordinateAliasRequestInterface;

use function array_filter;

final class CoordinateAliasRequestSerializer implements CoordinateAliasRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CoordinateAliasRequestInterface $request): array
    {
        return self::filter([
            self::KEY_LATITUDE => $request->getLatitude(),
            self::KEY_LONGITUDE => $request->getLongitude(),
            self::KEY_REGION_RADIUS => $request->getRegionRadius(),
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
