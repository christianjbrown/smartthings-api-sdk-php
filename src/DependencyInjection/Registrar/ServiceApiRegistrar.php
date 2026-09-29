<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ServiceSubscriptionRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceSubscriptionReceiptTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ServiceApiRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SERVICE_SUBSCRIPTION_REQUEST_SERIALIZER, ServiceSubscriptionRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_MEASUREMENT_TRANSFORMER, ServiceMeasurementTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_MEASUREMENTS_TRANSFORMER, ServiceMeasurementsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_MEASUREMENT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_TRANSFORMER, ServiceCapabilityDataTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_MEASUREMENTS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_NAMES_TRANSFORMER, ServiceCapabilityNamesTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_SUBSCRIPTION_TRANSFORMER, ServiceLocationInfoSubscriptionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_SUBSCRIPTIONS_TRANSFORMER, ServiceLocationInfoSubscriptionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_SUBSCRIPTION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_TRANSFORMER, ServiceLocationInfoTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SERVICE_LOCATION_INFO_SUBSCRIPTIONS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_SUBSCRIPTION_RECEIPT_TRANSFORMER, ServiceSubscriptionReceiptTransformer::class);
    }
}
