<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DevicePreferenceDefinitionRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER, DevicePreferenceDefinitionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PREFERENCE_REQUEST_SERIALIZER, PreferenceRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITIONS_TRANSFORMER, DevicePreferenceDefinitionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER),
                ]
            );
    }
}
