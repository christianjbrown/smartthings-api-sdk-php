<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Location;
use ChristianBrown\SmartThings\Model\LocationDetailsInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_values;
use function is_array;
use function is_int;
use function is_numeric;
use function is_string;
use function sprintf;

final class LocationTransformer implements LocationTransformerInterface
{
    private LocationDetailsTransformerInterface $locationDetailsTransformer;

    public function __construct(LocationDetailsTransformerInterface $locationDetailsTransformer)
    {
        $this->locationDetailsTransformer = $locationDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        $location = new Location($data[self::KEY_LOCATION_ID]);

        self::applyName($location, $data);

        self::applyCountryCode($location, $data);
        self::applyLatitude($location, $data);
        self::applyLongitude($location, $data);
        self::applyRegionRadius($location, $data);
        self::applyTemperatureScale($location, $data);
        self::applyTimeZoneId($location, $data);
        self::applyLocale($location, $data);
        self::applyBackgroundImage($location, $data);
        self::applyAdditionalProperties($location, $data);
        self::applyAllowed($location, $data);
        self::applyCreated($location, $data);
        self::applyLastModified($location, $data);

        $this->applyDetails($location, $data);

        return $location;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdditionalProperties(Location $model, array $data): void
    {
        if (!isset($data[self::KEY_ADDITIONAL_PROPERTIES])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_PROPERTIES])) {
            return;
        }
        $model->setAdditionalProperties(array_filter($data[self::KEY_ADDITIONAL_PROPERTIES], is_string(...)));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAllowed(Location $model, array $data): void
    {
        if (!isset($data[self::KEY_ALLOWED])) {
            return;
        }
        if (!is_array($data[self::KEY_ALLOWED])) {
            return;
        }
        $model->setAllowed(array_values(array_filter($data[self::KEY_ALLOWED], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBackgroundImage(Location $model, array $data): void
    {
        if (empty($data[self::KEY_BACKGROUND_IMAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_BACKGROUND_IMAGE])) {
            return;
        }
        $model->setBackgroundImage($data[self::KEY_BACKGROUND_IMAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryCode(Location $model, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_CODE])) {
            return;
        }
        $model->setCountryCode($data[self::KEY_COUNTRY_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCreated(Location $model, array $data): void
    {
        if (empty($data[self::KEY_CREATED])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATED])) {
            return;
        }
        $model->setCreated($data[self::KEY_CREATED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(Location $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->locationDetailsTransformer->transform($data);
        self::copyParent($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastModified(Location $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_MODIFIED])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_MODIFIED])) {
            return;
        }
        $model->setLastModified($data[self::KEY_LAST_MODIFIED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLatitude(Location $model, array $data): void
    {
        if (!isset($data[self::KEY_LATITUDE])) {
            return;
        }
        if (!is_numeric($data[self::KEY_LATITUDE])) {
            return;
        }
        $model->setLatitude((float) $data[self::KEY_LATITUDE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocale(Location $model, array $data): void
    {
        if (empty($data[self::KEY_LOCALE])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCALE])) {
            return;
        }
        $model->setLocale($data[self::KEY_LOCALE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLongitude(Location $model, array $data): void
    {
        if (!isset($data[self::KEY_LONGITUDE])) {
            return;
        }
        if (!is_numeric($data[self::KEY_LONGITUDE])) {
            return;
        }
        $model->setLongitude((float) $data[self::KEY_LONGITUDE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Location $location, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $location->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegionRadius(Location $model, array $data): void
    {
        if (!isset($data[self::KEY_REGION_RADIUS])) {
            return;
        }
        if (!is_int($data[self::KEY_REGION_RADIUS])) {
            return;
        }
        $model->setRegionRadius($data[self::KEY_REGION_RADIUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTemperatureScale(Location $model, array $data): void
    {
        if (empty($data[self::KEY_TEMPERATURE_SCALE])) {
            return;
        }
        if (!is_string($data[self::KEY_TEMPERATURE_SCALE])) {
            return;
        }
        $model->setTemperatureScale($data[self::KEY_TEMPERATURE_SCALE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeZoneId(Location $model, array $data): void
    {
        if (empty($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        $model->setTimeZoneId($data[self::KEY_TIME_ZONE_ID]);
    }

    private static function copyParent(Location $model, LocationDetailsInterface $details): void
    {
        $model->setParent($details->getParent());
    }
}
