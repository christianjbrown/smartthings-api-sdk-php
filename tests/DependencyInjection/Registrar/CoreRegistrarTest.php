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
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PAGING_JSON_API_REQUEST_SENDER));
        self::assertSame($container->getDefinition(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER), $container->getDefinition(SmartThingsInterface::SERVICE_PAGING_JSON_API_REQUEST_SENDER)->getArgument(0));
        self::assertSame(100, $container->getDefinition(SmartThingsInterface::SERVICE_PAGING_JSON_API_REQUEST_SENDER)->getArgument(1));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_RAW_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_REQUEST_URL_BUILDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_RESPONSE_MAPPER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_MIDDLEWARE));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_HANDLER_STACK));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_HTTP_CLIENT));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_RAW_JSON_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALERT_LINK_JSON_API_REQUEST_SENDER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_API_ERROR_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ERROR_RESPONSE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DRIVER_PACKAGE_UPLOADER));
    }
}
