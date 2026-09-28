<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\LocationRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(LocationRegistrar::class)]
final class LocationRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new LocationRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATIONS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_CREATE_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_PATCH_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOMS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_ROOM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCATION_UPDATE_REQUEST_SERIALIZER));
    }
}
