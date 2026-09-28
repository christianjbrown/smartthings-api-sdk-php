<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CoordinateAliasRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateInstalledAppEventsRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class InstalledAppRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_COORDINATE_ALIAS_REQUEST_SERIALIZER, CoordinateAliasRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_CREATE_INSTALLED_APP_EVENTS_REQUEST_SERIALIZER, CreateInstalledAppEventsRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER, InstalledAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APPS_TRANSFORMER, InstalledAppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER, InstalledAppConfigTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER, InstalledAppConfigsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER),
                ]
            );
    }
}
