<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\ApiRequestSender;
use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSender;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformer;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformer;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\DriverPackageUploader;
use ChristianBrown\SmartThings\Api\HostOverridingJsonApiRequestSender;
use ChristianBrown\SmartThings\Api\RedirectLocationResponseMapper;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CoreRegistrar implements ServiceRegistrarInterface
{
    private const string GUZZLE_HANDLER_OPTION = 'handler';
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
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_RESPONSE_MAPPER, RedirectLocationResponseMapper::class);
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_MIDDLEWARE, Closure::class)
            ->setFactory([Middleware::class, 'mapResponse'])
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_ALERT_LINK_RESPONSE_MAPPER)]);
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_HANDLER_STACK, HandlerStack::class)
            ->setFactory([HandlerStack::class, 'create'])
            ->addMethodCall('push', [new Reference(SmartThingsInterface::SERVICE_ALERT_LINK_MIDDLEWARE)]);
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_HTTP_CLIENT, Client::class)
            ->setArguments([[self::GUZZLE_HANDLER_OPTION => new Reference(SmartThingsInterface::SERVICE_ALERT_LINK_HANDLER_STACK), RequestOptions::ALLOW_REDIRECTS => false]]);
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_API_REQUEST_SENDER, ApiRequestSender::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_ALERT_LINK_HTTP_CLIENT)]);
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_RAW_JSON_API_REQUEST_SENDER, JsonApiRequestSender::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALERT_LINK_API_REQUEST_SENDER),
                    new Reference(SmartThingsInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ALERT_LINK_JSON_API_REQUEST_SENDER, HostOverridingJsonApiRequestSender::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALERT_LINK_RAW_JSON_API_REQUEST_SENDER),
                    $this->apiHost,
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_JSON_TO_ARRAY_TRANSFORMER, JsonToArrayTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ARRAY_TO_JSON_TRANSFORMER, ArrayToJsonTransformer::class);
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
