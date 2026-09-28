<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\LocationPatchFieldInterface;
use ChristianBrown\SmartThings\Model\PatchLocationRequestInterface;

use function array_filter;
use function array_map;

final class PatchLocationRequestSerializer implements PatchLocationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PatchLocationRequestInterface $request): array
    {
        $fields = [
            self::KEY_LATITUDE => $request->getLatitude(),
            self::KEY_LONGITUDE => $request->getLongitude(),
            self::KEY_REGION_RADIUS => $request->getRegionRadius(),
        ];

        // Fields the caller never set are omitted entirely rather than sent as
        // explicit nulls, leaving them untouched on the location.
        $set = array_filter($fields, static fn (?LocationPatchFieldInterface $field): bool => null !== $field);

        return array_map(static fn (LocationPatchFieldInterface $field): array => self::serializeField($field), $set);
    }

    /**
     * @return mixed[]
     */
    private static function serializeField(LocationPatchFieldInterface $field): array
    {
        $serialized = [
            self::KEY_VALUE => $field->getValue(),
            self::KEY_TO_NULL => $field->isToNull() ? true : null,
        ];

        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
