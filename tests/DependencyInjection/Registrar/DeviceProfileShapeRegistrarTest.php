<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceProfileShapeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DeviceProfileShapeRegistrar::class)]
final class DeviceProfileShapeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new DeviceProfileShapeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_VALUE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_RESTRICTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_REFERENCE_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CATEGORY_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PREFERENCE_DEFINITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_RESTRICTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_VALUE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_RESTRICTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ATTRIBUTE_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CAPABILITY_REFERENCE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CATEGORY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_DETAILS_TRANSFORMER));
    }
}
