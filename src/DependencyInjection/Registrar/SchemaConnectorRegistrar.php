<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SchemaConnectorRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_TRANSFORMER, SchemaAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APPS_TRANSFORMER, SchemaAppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEMA_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_TRANSFORMER, InstalledSchemaAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APPS_TRANSFORMER, InstalledSchemaAppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_PAGE_TRANSFORMER, SchemaPageTransformer::class);
    }
}
