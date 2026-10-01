<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\PageLinksTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinkTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteAcceptanceTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInvitePageTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteReceiptTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteStatusTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SchemaAppInviteShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_RECEIPT_TRANSFORMER, SchemaAppInviteReceiptTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_ACCEPTANCE_TRANSFORMER, SchemaAppInviteAcceptanceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_TRANSFORMER, SchemaAppInviteTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PAGE_LINK_TRANSFORMER, PageLinkTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PAGE_LINKS_TRANSFORMER, PageLinksTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PAGE_LINK_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_PAGE_TRANSFORMER, SchemaAppInvitePageTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PAGE_LINKS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_STATUS_TRANSFORMER, SchemaAppInviteStatusTransformer::class);
    }
}
