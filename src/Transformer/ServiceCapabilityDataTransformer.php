<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceCapabilityData;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataDetailsInterface;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class ServiceCapabilityDataTransformer implements ServiceCapabilityDataTransformerInterface
{
    private ServiceCapabilityDataDetailsTransformerInterface $serviceCapabilityDataDetailsTransformer;
    private ServiceMeasurementsTransformerInterface $serviceMeasurementsTransformer;

    public function __construct(ServiceMeasurementsTransformerInterface $serviceMeasurementsTransformer, ServiceCapabilityDataDetailsTransformerInterface $serviceCapabilityDataDetailsTransformer)
    {
        $this->serviceMeasurementsTransformer = $serviceMeasurementsTransformer;
        $this->serviceCapabilityDataDetailsTransformer = $serviceCapabilityDataDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataInterface
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        $capabilityData = new ServiceCapabilityData($data[self::KEY_LOCATION_ID]);

        $this->applyAirQuality($capabilityData, $data);
        $this->applyAirQualityForecast($capabilityData, $data);
        $this->applyForecast($capabilityData, $data);
        $this->applyWeather($capabilityData, $data);

        self::applyName($capabilityData, $data);

        $this->applyDetails($capabilityData, $data);

        return $capabilityData;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAirQuality(ServiceCapabilityData $capabilityData, array $data): void
    {
        if (empty($data[self::KEY_AIR_QUALITY])) {
            return;
        }
        if (!is_array($data[self::KEY_AIR_QUALITY])) {
            return;
        }
        $capabilityData->setAirQuality($this->serviceMeasurementsTransformer->transform($data[self::KEY_AIR_QUALITY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAirQualityForecast(ServiceCapabilityData $capabilityData, array $data): void
    {
        if (empty($data[self::KEY_AIR_QUALITY_FORECAST])) {
            return;
        }
        if (!is_array($data[self::KEY_AIR_QUALITY_FORECAST])) {
            return;
        }
        $capabilityData->setAirQualityForecast($this->serviceMeasurementsTransformer->transform($data[self::KEY_AIR_QUALITY_FORECAST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(ServiceCapabilityData $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->serviceCapabilityDataDetailsTransformer->transform($data);
        self::copyAlert($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyForecast(ServiceCapabilityData $capabilityData, array $data): void
    {
        if (empty($data[self::KEY_FORECAST])) {
            return;
        }
        if (!is_array($data[self::KEY_FORECAST])) {
            return;
        }
        $capabilityData->setForecast($this->serviceMeasurementsTransformer->transform($data[self::KEY_FORECAST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(ServiceCapabilityData $model, array $data): void
    {
        if (!isset($data[self::KEY_NAME])) {
            return;
        }
        if (!is_array($data[self::KEY_NAME])) {
            return;
        }
        $model->setName(array_values(array_filter($data[self::KEY_NAME], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWeather(ServiceCapabilityData $capabilityData, array $data): void
    {
        if (empty($data[self::KEY_WEATHER])) {
            return;
        }
        if (!is_array($data[self::KEY_WEATHER])) {
            return;
        }
        $capabilityData->setWeather($this->serviceMeasurementsTransformer->transform($data[self::KEY_WEATHER]));
    }

    private static function copyAlert(ServiceCapabilityData $model, ServiceCapabilityDataDetailsInterface $details): void
    {
        $model->setAlert($details->getAlert() ?? []);
    }
}
