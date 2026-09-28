<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceProfileRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DeviceProfileRegistrar::class)]
final class DeviceProfileRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new DeviceProfileRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILES_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_TRANSFORMER));
    }
}
