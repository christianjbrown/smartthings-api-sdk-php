<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateLocationRequestInterface;

interface CreateLocationRequestSerializerInterface
{
    public const string KEY_COUNTRY_CODE = 'countryCode';
    public const string KEY_LATITUDE = 'latitude';
    public const string KEY_LOCALE = 'locale';
    public const string KEY_LONGITUDE = 'longitude';
    public const string KEY_NAME = 'name';
    public const string KEY_REGION_RADIUS = 'regionRadius';
    public const string KEY_TEMPERATURE_SCALE = 'temperatureScale';
    public const string KEY_TIME_ZONE_ID = 'timeZoneId';

    /**
     * @return mixed[]
     */
    public function serialize(CreateLocationRequestInterface $request): array;
}
