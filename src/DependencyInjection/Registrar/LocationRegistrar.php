<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class LocationRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LOCATION_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCATION_CREATE_REQUEST_SERIALIZER, CreateLocationRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_UPDATE_REQUEST_SERIALIZER, UpdateLocationRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_PATCH_REQUEST_SERIALIZER, PatchLocationRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER),
                ]
            );

        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER, LocationRoomTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LOCATION_ROOM_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOMS_TRANSFORMER, LocationRoomsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER),
                ]
            );
    }
}
