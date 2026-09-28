<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationsTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class OrganizationRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_ORGANIZATION_TRANSFORMER, OrganizationTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ORGANIZATIONS_TRANSFORMER, OrganizationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_ORGANIZATION_TRANSFORMER),
                ]
            );
    }
}
