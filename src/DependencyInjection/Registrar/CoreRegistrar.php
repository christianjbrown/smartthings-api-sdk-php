<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CoreRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_API_CLIENT, ApiClient::class);
        $container->register(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(SmartThingsInterface::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);
    }
}
