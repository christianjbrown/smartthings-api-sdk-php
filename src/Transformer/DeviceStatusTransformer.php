<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatus;
use ChristianBrown\SmartThings\Model\DeviceStatusInterface;

use function is_array;

final class DeviceStatusTransformer implements DeviceStatusTransformerInterface
{
    private DeviceStatusBatteryTransformerInterface $deviceStatusBatteryTransformer;
    private DeviceStatusRelativeHumidityMeasurementTransformerInterface $deviceStatusRelativeHumidityMeasurementTransformer;
    private DeviceStatusTemperatureMeasurementTransformerInterface $deviceStatusTemperatureMeasurementTransformer;

    public function __construct(DeviceStatusTemperatureMeasurementTransformerInterface $deviceStatusTemperatureMeasurementTransformer, DeviceStatusRelativeHumidityMeasurementTransformerInterface $deviceStatusRelativeHumidityMeasurementTransformer, DeviceStatusBatteryTransformerInterface $deviceStatusBatteryTransformer)
    {
        $this->deviceStatusTemperatureMeasurementTransformer = $deviceStatusTemperatureMeasurementTransformer;
        $this->deviceStatusRelativeHumidityMeasurementTransformer = $deviceStatusRelativeHumidityMeasurementTransformer;
        $this->deviceStatusBatteryTransformer = $deviceStatusBatteryTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusInterface
    {
        $status = new DeviceStatus();
        if (!empty($data[self::KEY_TEMPERATURE_MEASUREMENT])) {
            if (is_array($data[self::KEY_TEMPERATURE_MEASUREMENT])) {
                $temperatureMeasurement = $this->deviceStatusTemperatureMeasurementTransformer->transform($data[self::KEY_TEMPERATURE_MEASUREMENT]);
                $status->setTemperatureMeasurement($temperatureMeasurement);
            }
        }
        if (!empty($data[self::KEY_RELATIVE_HUMIDITY_MEASUREMENT])) {
            if (is_array($data[self::KEY_RELATIVE_HUMIDITY_MEASUREMENT])) {
                $relativeHumidityMeasurement = $this->deviceStatusRelativeHumidityMeasurementTransformer->transform($data[self::KEY_RELATIVE_HUMIDITY_MEASUREMENT]);
                $status->setRelativeHumidityMeasurement($relativeHumidityMeasurement);
            }
        }
        if (!empty($data[self::KEY_BATTERY])) {
            if (is_array($data[self::KEY_BATTERY])) {
                $battery = $this->deviceStatusBatteryTransformer->transform($data[self::KEY_BATTERY]);
                $status->setBattery($battery);
            }
        }

        return $status;
    }
}
