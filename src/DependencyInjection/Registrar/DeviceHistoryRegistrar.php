<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DeviceHistoryRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HISTORY_EVENT_TRANSFORMER, DeviceHistoryEventTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HISTORY_EVENTS_TRANSFORMER, DeviceHistoryEventsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_DEVICE_HISTORY_EVENT_TRANSFORMER),
                ]
            );
    }
}
