<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\DevicePreferenceRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DevicePreferenceRegistrar::class)]
final class DevicePreferenceRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new DevicePreferenceRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_TRANSFORMER));
    }
}
