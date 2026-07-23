<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceCapabilityData implements ServiceCapabilityDataInterface
{
    /**
     * @var array<string, ServiceMeasurementInterface>
     */
    private array $airQuality = [];

    /**
     * @var array<string, ServiceMeasurementInterface>
     */
    private array $airQualityForecast = [];

    /**
     * @var array<string, ServiceMeasurementInterface>
     */
    private array $forecast = [];
    private string $locationId;

    /**
     * @var array<string, ServiceMeasurementInterface>
     */
    private array $weather = [];

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getAirQuality(): array
    {
        return $this->airQuality;
    }

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getAirQualityForecast(): array
    {
        return $this->airQualityForecast;
    }

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getForecast(): array
    {
        return $this->forecast;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getWeather(): array
    {
        return $this->weather;
    }

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setAirQuality(array $value): ServiceCapabilityDataInterface
    {
        $this->airQuality = $value;

        return $this;
    }

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setAirQualityForecast(array $value): ServiceCapabilityDataInterface
    {
        $this->airQualityForecast = $value;

        return $this;
    }

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setForecast(array $value): ServiceCapabilityDataInterface
    {
        $this->forecast = $value;

        return $this;
    }

    public function setLocationId(string $value): ServiceCapabilityDataInterface
    {
        $this->locationId = $value;

        return $this;
    }

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setWeather(array $value): ServiceCapabilityDataInterface
    {
        $this->weather = $value;

        return $this;
    }
}
