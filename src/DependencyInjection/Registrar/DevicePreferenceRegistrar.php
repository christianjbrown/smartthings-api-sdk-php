<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferencesTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DevicePreferenceRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_TRANSFORMER, DevicePreferenceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCES_TRANSFORMER, DevicePreferencesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_TRANSFORMER),
                ]
            );
    }
}
