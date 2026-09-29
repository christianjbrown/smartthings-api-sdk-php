<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationInterface;

interface LocationTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_PARENT];
    public const string KEY_ADDITIONAL_PROPERTIES = 'additionalProperties';
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_BACKGROUND_IMAGE = 'backgroundImage';
    public const string KEY_COUNTRY_CODE = 'countryCode';
    public const string KEY_CREATED = 'created';
    public const string KEY_LAST_MODIFIED = 'lastModified';
    public const string KEY_LATITUDE = 'latitude';
    public const string KEY_LOCALE = 'locale';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_LONGITUDE = 'longitude';
    public const string KEY_NAME = 'name';
    public const string KEY_PARENT = 'parent';
    public const string KEY_REGION_RADIUS = 'regionRadius';
    public const string KEY_TEMPERATURE_SCALE = 'temperatureScale';
    public const string KEY_TIME_ZONE_ID = 'timeZoneId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface;
}
