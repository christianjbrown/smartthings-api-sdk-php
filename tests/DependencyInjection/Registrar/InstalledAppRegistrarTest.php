<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\InstalledAppRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(InstalledAppRegistrar::class)]
final class InstalledAppRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new InstalledAppRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_COORDINATE_ALIAS_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CREATE_INSTALLED_APP_EVENTS_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INSTALLED_APPS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER));
    }
}
