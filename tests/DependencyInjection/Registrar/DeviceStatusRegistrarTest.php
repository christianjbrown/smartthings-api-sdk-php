<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceStatusRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DeviceStatusRegistrar::class)]
final class DeviceStatusRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new DeviceStatusRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_BATTERY_BATTERY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_BATTERY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_HUMIDITY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TEMPERATURE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_STATUS_TRANSFORMER));
    }
}
