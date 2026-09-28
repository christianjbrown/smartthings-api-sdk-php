<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\ChannelRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ChannelRegistrar::class)]
final class ChannelRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new ChannelRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CHANNELS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CHANNEL_DRIVERS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CHANNEL_DRIVER_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CHANNEL_TRANSFORMER));
    }
}
