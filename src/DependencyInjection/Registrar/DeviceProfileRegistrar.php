<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DeviceProfileRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_TRANSFORMER, DeviceProfileTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PROFILE_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_CREATE_REQUEST_SERIALIZER, CreateDeviceProfileRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_REQUEST_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PREFERENCE_REQUEST_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_UPDATE_REQUEST_SERIALIZER, UpdateDeviceProfileRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_REQUEST_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PREFERENCE_REQUEST_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILES_TRANSFORMER, DeviceProfilesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_TRANSFORMER),
                ]
            );
    }
}
