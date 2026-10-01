<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ClustersTransformer;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformer;
use ChristianBrown\SmartThings\Transformer\DriverDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DriverFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeGenericFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeManufacturerFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZWaveGenericFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZWaveManufacturerFingerprintTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DriverShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER, DeviceIntegrationProfileKeyTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DRIVER_PERMISSION_TRANSFORMER, DriverPermissionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CLUSTERS_TRANSFORMER, ClustersTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ZIGBEE_GENERIC_FINGERPRINT_TRANSFORMER, ZigbeeGenericFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CLUSTERS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ZIGBEE_MANUFACTURER_FINGERPRINT_TRANSFORMER, ZigbeeManufacturerFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ZWAVE_MANUFACTURER_FINGERPRINT_TRANSFORMER, ZWaveManufacturerFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_COMMAND_CLASSES_TRANSFORMER, CommandClassesTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ZWAVE_GENERIC_FINGERPRINT_TRANSFORMER, ZWaveGenericFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_COMMAND_CLASSES_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DRIVER_FINGERPRINT_TRANSFORMER, DriverFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ZIGBEE_GENERIC_FINGERPRINT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZIGBEE_MANUFACTURER_FINGERPRINT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZWAVE_MANUFACTURER_FINGERPRINT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZWAVE_GENERIC_FINGERPRINT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DRIVER_DETAILS_TRANSFORMER, DriverDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DRIVER_PERMISSION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DRIVER_FINGERPRINT_TRANSFORMER),
                ]
            );
    }
}
