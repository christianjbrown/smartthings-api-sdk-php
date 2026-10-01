<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationValueSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityReferenceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCategorySerializer;
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PreferenceDefinitionSerializer;
use ChristianBrown\SmartThings\Serializer\RestrictionSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCapabilityReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRestrictionTransformer;
use ChristianBrown\SmartThings\Transformer\RestrictionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DeviceProfileShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_VALUE_SERIALIZER, CapabilityConfigurationValueSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_SERIALIZER, CapabilityConfigurationSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_VALUE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RESTRICTION_SERIALIZER, RestrictionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_REFERENCE_REQUEST_SERIALIZER, CapabilityReferenceRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_RESTRICTION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CATEGORY_SERIALIZER, DeviceCategorySerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_REQUEST_SERIALIZER, DeviceProfileComponentRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_REFERENCE_REQUEST_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CATEGORY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_RESTRICTION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PREFERENCE_DEFINITION_SERIALIZER, PreferenceDefinitionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_RESTRICTION_TRANSFORMER, DeviceRestrictionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER, DevicePreferenceDefinitionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_VALUE_TRANSFORMER, CapabilityConfigurationValueTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_TRANSFORMER, CapabilityConfigurationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_VALUE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RESTRICTION_TRANSFORMER, RestrictionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_STATE_TRANSFORMER, AttributeStateTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CAPABILITY_REFERENCE_TRANSFORMER, DeviceCapabilityReferenceTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_CONFIGURATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_RESTRICTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CATEGORY_TRANSFORMER, DeviceCategoryTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_TRANSFORMER, DeviceProfileComponentTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CAPABILITY_REFERENCE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CATEGORY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_RESTRICTION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_DETAILS_TRANSFORMER, DeviceProfileDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_RESTRICTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PREFERENCE_DEFINITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PROFILE_COMPONENT_TRANSFORMER),
                ]
            );
    }
}
