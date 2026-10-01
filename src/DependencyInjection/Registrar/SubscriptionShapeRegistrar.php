<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\SceneLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\SecurityArmStateDetailTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SubscriptionShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_SUBSCRIPTION_DETAIL_TRANSFORMER, DeviceSubscriptionDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_SUBSCRIPTION_DETAIL_TRANSFORMER, CapabilitySubscriptionDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_MODE_SUBSCRIPTION_DETAIL_TRANSFORMER, ModeSubscriptionDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_LIFECYCLE_DETAIL_TRANSFORMER, DeviceLifecycleDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_HEALTH_DETAIL_TRANSFORMER, DeviceHealthDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SECURITY_ARM_STATE_DETAIL_TRANSFORMER, SecurityArmStateDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_HEALTH_DETAIL_TRANSFORMER, HubHealthDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCENE_LIFECYCLE_DETAIL_TRANSFORMER, SceneLifecycleDetailTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SUBSCRIPTION_DETAILS_TRANSFORMER, SubscriptionDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_SUBSCRIPTION_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_SUBSCRIPTION_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MODE_SUBSCRIPTION_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_LIFECYCLE_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_HEALTH_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SECURITY_ARM_STATE_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_HUB_HEALTH_DETAIL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SCENE_LIFECYCLE_DETAIL_TRANSFORMER),
                ]
            );
    }
}
