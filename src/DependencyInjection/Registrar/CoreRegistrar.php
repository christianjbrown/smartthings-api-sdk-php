<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformer;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\DriverPackageUploader;
use ChristianBrown\SmartThings\Api\HostOverridingJsonApiRequestSender;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CoreRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_API_CLIENT, ApiClient::class);
        $container->register(SmartThingsInterface::SERVICE_RAW_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(SmartThingsInterface::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);
        $container->register(SmartThingsInterface::SERVICE_JSON_API_REQUEST_SENDER, HostOverridingJsonApiRequestSender::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_RAW_JSON_API_REQUEST_SENDER),
                    $this->apiHost,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RAW_API_REQUEST_SENDER, ApiRequestSenderInterface::class)
            ->setFactory([new Reference(SmartThingsInterface::SERVICE_API_CLIENT), 'getApiRequestSender']);
        $container->register(SmartThingsInterface::SERVICE_REQUEST_URL_BUILDER, RequestUrlBuilder::class);
        $container->register(SmartThingsInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER, JsonToArrayTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DRIVER_PACKAGE_UPLOADER, DriverPackageUploader::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_RAW_API_REQUEST_SENDER),
                    $container->getDefinition(SmartThingsInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER),
                    $this->apiHost,
                ]
            );
    }
}
