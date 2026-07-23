<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;

interface ServiceLocationInfoTransformerInterface
{
    public const string KEY_CITY = 'city';
    public const string KEY_LATITUDE = 'latitude';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_LONGITUDE = 'longitude';
    public const string KEY_SUBSCRIPTIONS = 'subscriptions';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceLocationInfoInterface;
}
