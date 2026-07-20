<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatus;
use ChristianBrown\SmartThings\Model\DeviceStatusInterface;

use function array_keys;
use function array_map;
use function is_array;

final class DeviceStatusTransformer implements DeviceStatusTransformerInterface
{
    /**
     * @var array<string, callable(DeviceStatusInterface, mixed[]): DeviceStatusInterface>
     */
    private array $capabilityAppliers;

    public function __construct(DeviceStatusTemperatureMeasurementTransformerInterface $deviceStatusTemperatureMeasurementTransformer, DeviceStatusRelativeHumidityMeasurementTransformerInterface $deviceStatusRelativeHumidityMeasurementTransformer, DeviceStatusBatteryTransformerInterface $deviceStatusBatteryTransformer)
    {
        // Each capability registers a `key => applier` here; transform() dispatches
        // over this map, so a new capability is added by adding one entry — the
        // dispatch logic stays closed for modification.
        $this->capabilityAppliers = [
            self::KEY_TEMPERATURE_MEASUREMENT => static fn (DeviceStatusInterface $status, array $value): DeviceStatusInterface => $status->setTemperatureMeasurement($deviceStatusTemperatureMeasurementTransformer->transform($value)),
            self::KEY_RELATIVE_HUMIDITY_MEASUREMENT => static fn (DeviceStatusInterface $status, array $value): DeviceStatusInterface => $status->setRelativeHumidityMeasurement($deviceStatusRelativeHumidityMeasurementTransformer->transform($value)),
            self::KEY_BATTERY => static fn (DeviceStatusInterface $status, array $value): DeviceStatusInterface => $status->setBattery($deviceStatusBatteryTransformer->transform($value)),
        ];
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusInterface
    {
        $status = new DeviceStatus();

        array_map(
            fn (string $key): DeviceStatusInterface => $this->applyCapability($status, $data, $key),
            array_keys($this->capabilityAppliers)
        );

        return $status;
    }

    /**
     * @param DeviceStatusInterface $status
     * @param mixed[]               $data
     * @param string                $key
     */
    private function applyCapability(DeviceStatusInterface $status, array $data, string $key): DeviceStatusInterface
    {
        if (empty($data[$key])) {
            return $status;
        }
        if (!is_array($data[$key])) {
            return $status;
        }

        $applier = $this->capabilityAppliers[$key];

        return $applier($status, $data[$key]);
    }
}
