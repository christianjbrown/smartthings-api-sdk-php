<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppCreateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaAppInviteRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaAppUpdateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaOauthCredentialsRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppReceiptTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformer;
use ChristianBrown\SmartThings\Transformer\UserSchemaAppsTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SchemaConnectorRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_REQUEST_SERIALIZER, SchemaAppInviteRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_OAUTH_CREDENTIALS_REQUEST_SERIALIZER, SchemaOauthCredentialsRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_UPDATE_REQUEST_SERIALIZER, SchemaAppUpdateRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_CREATE_REQUEST_SERIALIZER, SchemaAppCreateRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_TRANSFORMER, SchemaAppTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SCHEMA_APP_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APPS_TRANSFORMER, SchemaAppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEMA_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_TRANSFORMER, InstalledSchemaAppTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APPS_TRANSFORMER, InstalledSchemaAppsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_PAGE_TRANSFORMER, SchemaPageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_RECEIPT_TRANSFORMER, SchemaAppReceiptTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ORGANIZATION_SCHEMA_APPS_TRANSFORMER, OrganizationSchemaAppsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SCHEMA_APPS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_USER_SCHEMA_APPS_TRANSFORMER, UserSchemaAppsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SCHEMA_APPS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                ]
            );
    }
}
