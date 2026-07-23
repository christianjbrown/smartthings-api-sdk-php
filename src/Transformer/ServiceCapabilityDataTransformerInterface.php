<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;

interface ServiceCapabilityDataTransformerInterface
{
    public const string KEY_AIR_QUALITY = 'airQuality';
    public const string KEY_AIR_QUALITY_FORECAST = 'airQualityForecast';
    public const string KEY_FORECAST = 'forecast';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_WEATHER = 'weather';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataInterface;
}
