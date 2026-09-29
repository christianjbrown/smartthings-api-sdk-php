<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CoreRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CoreRegistrar::class)]
final class CoreRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();
        $apiHost = self::createStub(ApiHostInterface::class);

        (new CoreRegistrar($apiHost))->register($container);

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_API_CLIENT));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_RAW_JSON_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_RAW_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DRIVER_PACKAGE_UPLOADER));
    }
}
