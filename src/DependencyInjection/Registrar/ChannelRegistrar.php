<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ChannelDriversTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelsTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ChannelRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_CHANNEL_TRANSFORMER, ChannelTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CHANNELS_TRANSFORMER, ChannelsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_CHANNEL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CHANNEL_DRIVER_TRANSFORMER, ChannelDriverTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CHANNEL_DRIVERS_TRANSFORMER, ChannelDriversTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_CHANNEL_DRIVER_TRANSFORMER),
                ]
            );
    }
}
