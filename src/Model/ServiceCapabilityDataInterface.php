<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceCapabilityDataInterface
{
    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getAirQuality(): array;

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getAirQualityForecast(): array;

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getForecast(): array;

    public function getLocationId(): string;

    /**
     * @return array<string, ServiceMeasurementInterface>
     */
    public function getWeather(): array;

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setAirQuality(array $value): self;

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setAirQualityForecast(array $value): self;

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setForecast(array $value): self;

    public function setLocationId(string $value): self;

    /**
     * @param array<string, ServiceMeasurementInterface> $value
     */
    public function setWeather(array $value): self;
}
