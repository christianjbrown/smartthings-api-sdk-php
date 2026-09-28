<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\PresentationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PresentationRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_TRANSFORMER, PresentationTransformer::class);
    }
}
