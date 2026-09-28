<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DevicesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DeviceRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_COMPONENT_CAPABILITY_TRANSFORMER, DeviceComponentCapabilityTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_COMPONENT_CAPABILITIES_TRANSFORMER, DeviceComponentCapabilitiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_COMPONENT_CAPABILITY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_COMPONENT_TRANSFORMER, DeviceComponentTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_COMPONENT_CAPABILITIES_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_COMPONENTS_TRANSFORMER, DeviceComponentsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_COMPONENT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_TRANSFORMER, DeviceTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_COMPONENTS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICES_TRANSFORMER, DevicesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_TRANSFORMER),
                ]
            );
    }
}
