<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DeviceResultsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SchemaAppShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_VIPER_APP_LINKS_TRANSFORMER, ViperAppLinksTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_DETAILS_TRANSFORMER, SchemaAppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VIPER_APP_LINKS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_RESULTS_TRANSFORMER, DeviceResultsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_DETAILS_TRANSFORMER, InstalledSchemaAppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_RESULTS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VIPER_APP_LINKS_TRANSFORMER),
                ]
            );
    }
}
