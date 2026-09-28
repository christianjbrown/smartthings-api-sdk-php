<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTemperatureTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DeviceStatusRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TEMPERATURE_TRANSFORMER, DeviceStatusTemperatureMeasurementTemperatureTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TRANSFORMER, DeviceStatusTemperatureMeasurementTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TEMPERATURE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_HUMIDITY_TRANSFORMER, DeviceStatusRelativeHumidityMeasurementHumidityTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_TRANSFORMER, DeviceStatusRelativeHumidityMeasurementTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_HUMIDITY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_BATTERY_BATTERY_TRANSFORMER, DeviceStatusBatteryBatteryTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_BATTERY_TRANSFORMER, DeviceStatusBatteryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_BATTERY_BATTERY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_STATUS_TRANSFORMER, DeviceStatusTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_TRANSFORMER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_BATTERY_TRANSFORMER),
                ]
            );
    }
}
