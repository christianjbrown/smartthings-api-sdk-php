<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateLocationRequestInterface;

use function array_filter;

final class CreateLocationRequestSerializer implements CreateLocationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CreateLocationRequestInterface $request): array
    {
        $serialized = [
            self::KEY_NAME => $request->getName(),
            self::KEY_COUNTRY_CODE => $request->getCountryCode(),
            self::KEY_LATITUDE => $request->getLatitude(),
            self::KEY_LONGITUDE => $request->getLongitude(),
            self::KEY_REGION_RADIUS => $request->getRegionRadius(),
            self::KEY_TEMPERATURE_SCALE => $request->getTemperatureScale(),
            self::KEY_TIME_ZONE_ID => $request->getTimeZoneId(),
            self::KEY_LOCALE => $request->getLocale(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
