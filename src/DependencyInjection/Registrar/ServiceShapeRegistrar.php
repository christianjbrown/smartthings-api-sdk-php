<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemLastUpdateTimeTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemSeverityTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataDetailsTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ServiceShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_LAST_UPDATE_TIME_TRANSFORMER, ServiceCapabilityDataAlertItemLastUpdateTimeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_SEVERITY_TRANSFORMER, ServiceCapabilityDataAlertItemSeverityTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_TRANSFORMER, ServiceCapabilityDataAlertItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_LAST_UPDATE_TIME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_SEVERITY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_DETAILS_TRANSFORMER, ServiceCapabilityDataDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_TRANSFORMER),
                ]
            );
    }
}
