<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ActionSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistry;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryFactory;
use ChristianBrown\SmartThings\Transformer\ActionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class TreeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_ACTION_SERIALIZER, ActionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_ACTION_NODE_TRANSFORMER_REGISTRY_FACTORY, NodeTransformerRegistryFactory::class);
        $container->register(SmartThingsInterface::SERVICE_ACTION_NODE_TRANSFORMER_REGISTRY, NodeTransformerRegistry::class)
            ->setFactory([new Reference(SmartThingsInterface::SERVICE_ACTION_NODE_TRANSFORMER_REGISTRY_FACTORY), 'create']);
        $container->register(SmartThingsInterface::SERVICE_ACTION_TRANSFORMER, ActionTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_ACTION_NODE_TRANSFORMER_REGISTRY)]);
    }
}
