<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLabelTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\LocalizationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CapabilityLocalizationShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_PREFERENCE_OPTION_LOCALIZATION_TRANSFORMER, PreferenceOptionLocalizationTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LABEL_TRANSFORMER, CapabilityAttributeLabelTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LOCALIZATION_TRANSFORMER, CapabilityAttributeLocalizationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LABEL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_I18N_TRANSFORMER, CapabilityArgumentI18nTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_LOCALIZATION_TRANSFORMER, CapabilityArgumentLocalizationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_I18N_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_COMMAND_LOCALIZATION_TRANSFORMER, CapabilityCommandLocalizationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_LOCALIZATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCALIZATION_DETAILS_TRANSFORMER, LocalizationDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PREFERENCE_OPTION_LOCALIZATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LOCALIZATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_COMMAND_LOCALIZATION_TRANSFORMER),
                ]
            );
    }
}
