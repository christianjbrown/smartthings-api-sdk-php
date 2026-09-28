<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformer;
use ChristianBrown\SmartThings\Transformer\ModeTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ModeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_MODE_TRANSFORMER, ModeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_MODES_TRANSFORMER, ModesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_MODE_TRANSFORMER),
                ]
            );
    }
}
