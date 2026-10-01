<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityAutomationShapeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CapabilityAutomationShapeRegistrar::class)]
final class CapabilityAutomationShapeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new CapabilityAutomationShapeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_VALUE_MAP_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SUPPORTED_OPERATORS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_CONDITIONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_ARGUMENT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_ARGUMENT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_ARGUMENT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_ARGUMENT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_ARGUMENTS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_ACTIONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_VALUE_MAP_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SUPPORTED_OPERATORS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_CONDITIONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_ARGUMENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_ARGUMENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_ARGUMENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_ARGUMENT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_ARGUMENTS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_ACTIONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_TRANSFORMER));
    }
}
