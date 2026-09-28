<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class LocationRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER),
                ]
            );

        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER, LocationRoomTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOMS_TRANSFORMER, LocationRoomsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER),
                ]
            );
    }
}
