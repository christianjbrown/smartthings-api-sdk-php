<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DriversTransformer;
use ChristianBrown\SmartThings\Transformer\DriverTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DriverRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DRIVER_TRANSFORMER, DriverTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DRIVERS_TRANSFORMER, DriversTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DRIVER_TRANSFORMER),
                ]
            );
    }
}
