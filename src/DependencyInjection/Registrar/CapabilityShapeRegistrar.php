<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AttributeDataSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributePropertiesTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeUnitSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CapabilityShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_VALUE_SCHEMA_TRANSFORMER, AttributeValueSchemaTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_UNIT_SCHEMA_TRANSFORMER, AttributeUnitSchemaTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_DATA_SCHEMA_TRANSFORMER, AttributeDataSchemaTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_PROPERTIES_TRANSFORMER, AttributePropertiesTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_VALUE_SCHEMA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_UNIT_SCHEMA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_DATA_SCHEMA_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_SCHEMA_TRANSFORMER, AttributeSchemaTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_PROPERTIES_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ENUM_COMMAND_TRANSFORMER, EnumCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_TRANSFORMER, CapabilityAttributeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_SCHEMA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ENUM_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_COMMAND_ARGUMENT_TRANSFORMER, CommandArgumentTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_COMMAND_TRANSFORMER, CapabilityCommandTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_COMMAND_ARGUMENT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_DETAILS_TRANSFORMER, CapabilityDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_COMMAND_TRANSFORMER),
                ]
            );
    }
}
