<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceStatusInterface
{
    public function getBattery(): ?DeviceStatusBatteryInterface;

    public function getRelativeHumidityMeasurement(): ?DeviceStatusRelativeHumidityMeasurementInterface;

    public function getTemperatureMeasurement(): ?DeviceStatusTemperatureMeasurementInterface;

    public function setBattery(?DeviceStatusBatteryInterface $battery): self;

    public function setRelativeHumidityMeasurement(?DeviceStatusRelativeHumidityMeasurementInterface $relativeHumidityMeasurement): self;

    public function setTemperatureMeasurement(?DeviceStatusTemperatureMeasurementInterface $temperatureMeasurement): self;
}
