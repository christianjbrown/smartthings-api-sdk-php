<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ScenesTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SceneRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SCENE_TRANSFORMER, SceneTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCENES_TRANSFORMER, ScenesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCENE_TRANSFORMER),
                ]
            );
    }
}
