<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateLocationRequestInterface;

use function array_filter;

final class UpdateLocationRequestSerializer implements UpdateLocationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateLocationRequestInterface $request): array
    {
        $serialized = [
            self::KEY_NAME => $request->getName(),
            self::KEY_LATITUDE => $request->getLatitude(),
            self::KEY_LONGITUDE => $request->getLongitude(),
            self::KEY_REGION_RADIUS => $request->getRegionRadius(),
            self::KEY_TEMPERATURE_SCALE => $request->getTemperatureScale(),
            self::KEY_TIME_ZONE_ID => $request->getTimeZoneId(),
            self::KEY_LOCALE => $request->getLocale(),
            self::KEY_ADDITIONAL_PROPERTIES => $request->getAdditionalProperties(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
