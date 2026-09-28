<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\I18nRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(I18nRegistrar::class)]
final class I18nRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new I18nRegistrar())->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCALE_REFERENCES_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCALE_REFERENCE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LOCALIZATION_TRANSFORMER));
    }
}
