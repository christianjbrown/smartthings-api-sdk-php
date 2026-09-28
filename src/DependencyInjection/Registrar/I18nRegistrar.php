<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformer;
use ChristianBrown\SmartThings\Transformer\LocaleReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class I18nRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_LOCALE_REFERENCE_TRANSFORMER, LocaleReferenceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCALE_REFERENCES_TRANSFORMER, LocaleReferencesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_LOCALE_REFERENCE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCALIZATION_TRANSFORMER, LocalizationTransformer::class);
    }
}
