<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformer;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppsTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AppRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_APP_TRANSFORMER, AppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APPS_TRANSFORMER, AppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_APP_OAUTH_TRANSFORMER, AppOauthTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_SETTINGS_TRANSFORMER, AppSettingsTransformer::class);
    }
}
