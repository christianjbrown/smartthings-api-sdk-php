<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection;

use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\DependencyInjection\ContainerFactory;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ContainerFactory::class)]
final class ContainerFactoryTest extends TestCase
{
    public function testBuild(): void
    {
        $container = (new ContainerFactory(new Token('test-token')))->build();

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_API_CLIENT));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_APP_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_API));
    }
}
