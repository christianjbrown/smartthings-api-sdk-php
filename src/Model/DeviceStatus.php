<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceStatus implements DeviceStatusInterface
{
    private ?DeviceStatusBatteryInterface $battery = null;
    private ?DeviceStatusRelativeHumidityMeasurementInterface $relativeHumidityMeasurement = null;
    private ?DeviceStatusTemperatureMeasurementInterface $temperatureMeasurement = null;

    public function getBattery(): ?DeviceStatusBatteryInterface
    {
        return $this->battery;
    }

    public function getRelativeHumidityMeasurement(): ?DeviceStatusRelativeHumidityMeasurementInterface
    {
        return $this->relativeHumidityMeasurement;
    }

    public function getTemperatureMeasurement(): ?DeviceStatusTemperatureMeasurementInterface
    {
        return $this->temperatureMeasurement;
    }

    public function setBattery(?DeviceStatusBatteryInterface $battery): DeviceStatusInterface
    {
        $this->battery = $battery;

        return $this;
    }

    public function setRelativeHumidityMeasurement(?DeviceStatusRelativeHumidityMeasurementInterface $relativeHumidityMeasurement): DeviceStatusInterface
    {
        $this->relativeHumidityMeasurement = $relativeHumidityMeasurement;

        return $this;
    }

    public function setTemperatureMeasurement(?DeviceStatusTemperatureMeasurementInterface $temperatureMeasurement): DeviceStatusInterface
    {
        $this->temperatureMeasurement = $temperatureMeasurement;

        return $this;
    }
}
