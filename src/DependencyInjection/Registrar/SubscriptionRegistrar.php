<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\SubscriptionRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SubscriptionRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTION_REQUEST_SERIALIZER, SubscriptionRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTION_TRANSFORMER, SubscriptionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUBSCRIPTION_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTIONS_TRANSFORMER, SubscriptionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SUBSCRIPTION_TRANSFORMER),
                ]
            );
    }
}
