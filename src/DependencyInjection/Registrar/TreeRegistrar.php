<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ActionSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ActionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class TreeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_ACTION_SERIALIZER, ActionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_ACTION_TRANSFORMER, ActionTransformer::class);
    }
}
