<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationParentTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\RoomIndoorMapTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class LocationShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_LOCATION_PARENT_TRANSFORMER, LocationParentTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_DETAILS_TRANSFORMER, LocationDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LOCATION_PARENT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ROOM_INDOOR_MAP_TRANSFORMER, RoomIndoorMapTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOM_DETAILS_TRANSFORMER, LocationRoomDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ROOM_INDOOR_MAP_TRANSFORMER),
                ]
            );
    }
}
