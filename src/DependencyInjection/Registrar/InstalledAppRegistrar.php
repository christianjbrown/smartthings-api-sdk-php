<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CoordinateAliasRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateInstalledAppEventsRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ConfigEntriesTransformer;
use ChristianBrown\SmartThings\Transformer\ConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use ChristianBrown\SmartThings\Transformer\MessageConfigTransformer;
use ChristianBrown\SmartThings\Transformer\ModeConfigTransformer;
use ChristianBrown\SmartThings\Transformer\PermissionConfigTransformer;
use ChristianBrown\SmartThings\Transformer\RoomConfigTransformer;
use ChristianBrown\SmartThings\Transformer\SceneConfigTransformer;
use ChristianBrown\SmartThings\Transformer\StringConfigTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class InstalledAppRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_COORDINATE_ALIAS_REQUEST_SERIALIZER, CoordinateAliasRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_CREATE_INSTALLED_APP_EVENTS_REQUEST_SERIALIZER, CreateInstalledAppEventsRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER, InstalledAppTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_INSTALLED_APP_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APPS_TRANSFORMER, InstalledAppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STRING_CONFIG_TRANSFORMER, StringConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_TRANSFORMER, DeviceConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_PERMISSION_CONFIG_TRANSFORMER, PermissionConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_MODE_CONFIG_TRANSFORMER, ModeConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_SCENE_CONFIG_TRANSFORMER, SceneConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_MESSAGE_CONFIG_TRANSFORMER, MessageConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_ROOM_CONFIG_TRANSFORMER, RoomConfigTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_CONFIG_ENTRY_TRANSFORMER, ConfigEntryTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                    new Reference(SmartThingsInterface::SERVICE_STRING_CONFIG_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PERMISSION_CONFIG_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MODE_CONFIG_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SCENE_CONFIG_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MESSAGE_CONFIG_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ROOM_CONFIG_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CONFIG_ENTRIES_TRANSFORMER, ConfigEntriesTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_CONFIG_ENTRY_TRANSFORMER)]);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER, InstalledAppConfigTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CONFIG_ENTRIES_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER, InstalledAppConfigsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER),
                ]
            );
    }
}
