<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CreateAppRequestSerializer;
use ChristianBrown\SmartThings\Serializer\GenerateAppOauthRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateAppOauthRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateAppRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateAppSettingsRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateSignatureTypeRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformer;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppsTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use ChristianBrown\SmartThings\Transformer\CreateAppResponseTransformer;
use ChristianBrown\SmartThings\Transformer\GenerateAppOauthResponseTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AppRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_UPDATE_SIGNATURE_TYPE_REQUEST_SERIALIZER, UpdateSignatureTypeRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_GENERATE_APP_OAUTH_REQUEST_SERIALIZER, GenerateAppOauthRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_UPDATE_APP_OAUTH_REQUEST_SERIALIZER, UpdateAppOauthRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_UPDATE_APP_SETTINGS_REQUEST_SERIALIZER, UpdateAppSettingsRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_UPDATE_APP_REQUEST_SERIALIZER, UpdateAppRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_CREATE_APP_REQUEST_SERIALIZER, CreateAppRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_TRANSFORMER, AppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APPS_TRANSFORMER, AppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_APP_OAUTH_TRANSFORMER, AppOauthTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_SETTINGS_TRANSFORMER, AppSettingsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CREATE_APP_RESPONSE_TRANSFORMER, CreateAppResponseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_GENERATE_APP_OAUTH_RESPONSE_TRANSFORMER, GenerateAppOauthResponseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_OAUTH_TRANSFORMER),
                ]
            );
    }
}
