<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespaceTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class CapabilityRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_TRANSFORMER, CapabilityTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITIES_TRANSFORMER, CapabilitiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_CAPABILITY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_NAMESPACE_TRANSFORMER, CapabilityNamespaceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_NAMESPACES_TRANSFORMER, CapabilityNamespacesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_CAPABILITY_NAMESPACE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_PRESENTATION_TRANSFORMER, CapabilityPresentationTransformer::class);
    }
}
