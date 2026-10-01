<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\TreeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(TreeRegistrar::class)]
final class TreeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new TreeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_NODE_SERIALIZER_REGISTRY));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_NODE_SERIALIZER_REGISTRY_FACTORY));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_NODE_TRANSFORMER_REGISTRY));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_NODE_TRANSFORMER_REGISTRY_FACTORY));
    }
}
