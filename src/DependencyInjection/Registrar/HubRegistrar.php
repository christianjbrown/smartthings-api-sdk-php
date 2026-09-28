<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformer;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformer;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class HubRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_HUB_TRANSFORMER, HubTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_CHARACTERISTICS_TRANSFORMER, HubCharacteristicsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVER_TRANSFORMER, HubInstalledDriverTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVERS_TRANSFORMER, HubInstalledDriversTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_INSTALLED_DRIVER_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_HUB_ENROLLED_CHANNEL_TRANSFORMER, HubEnrolledChannelTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_ENROLLED_CHANNELS_TRANSFORMER, HubEnrolledChannelsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_HUB_ENROLLED_CHANNEL_TRANSFORMER),
                ]
            );
    }
}
