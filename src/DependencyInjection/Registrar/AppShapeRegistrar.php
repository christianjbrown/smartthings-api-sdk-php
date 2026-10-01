<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\IconImageTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppIconImageTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppUiTransformer;
use ChristianBrown\SmartThings\Transformer\LambdaSmartAppTransformer;
use ChristianBrown\SmartThings\Transformer\NoticeTransformer;
use ChristianBrown\SmartThings\Transformer\OwnerTransformer;
use ChristianBrown\SmartThings\Transformer\WebhookSmartAppTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class AppShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_OWNER_TRANSFORMER, OwnerTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_NOTICE_TRANSFORMER, NoticeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_UI_TRANSFORMER, InstalledAppUiTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_ICON_IMAGE_TRANSFORMER, InstalledAppIconImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_DETAILS_TRANSFORMER, InstalledAppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_OWNER_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NOTICE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_INSTALLED_APP_UI_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_INSTALLED_APP_ICON_IMAGE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ICON_IMAGE_TRANSFORMER, IconImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LAMBDA_SMART_APP_TRANSFORMER, LambdaSmartAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_WEBHOOK_SMART_APP_TRANSFORMER, WebhookSmartAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_UI_SETTINGS_TRANSFORMER, AppUiSettingsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_DETAILS_TRANSFORMER, AppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ICON_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_OWNER_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LAMBDA_SMART_APP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_WEBHOOK_SMART_APP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_APP_UI_SETTINGS_TRANSFORMER),
                ]
            );
    }
}
