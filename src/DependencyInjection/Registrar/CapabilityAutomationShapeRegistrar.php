<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityConditionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSupportedOperatorsItemSerializer;
use ChristianBrown\SmartThings\Serializer\ListForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\ListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\ListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandArgumentsItemSerializer;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListSerializer;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListValueMapSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationConditionSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityConditionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandArgumentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationConditionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CapabilityAutomationShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_SERIALIZER, SliderForAutomationConditionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_SERIALIZER, ListForAutomationConditionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_VALUE_MAP_SERIALIZER, SupportedValuesForDynamicListValueMapSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_SERIALIZER, SupportedValuesForDynamicListSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_VALUE_MAP_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_SERIALIZER, DynamicListForAutomationConditionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_SERIALIZER, NumberFieldForAutomationConditionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_SERIALIZER, TextFieldForAutomationConditionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SUPPORTED_OPERATORS_ITEM_SERIALIZER, EnumSliderForAutomationConditionSupportedOperatorsItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SERIALIZER, EnumSliderForAutomationConditionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SUPPORTED_OPERATORS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_CONDITIONS_ITEM_SERIALIZER, AutomationForCapabilityConditionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_SERIALIZER, SliderForAutomationActionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_SERIALIZER, ListForAutomationActionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_SERIALIZER, DynamicListForAutomationActionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_SERIALIZER, TextFieldForAutomationActionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_SERIALIZER, NumberFieldForAutomationActionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_ARGUMENT_SERIALIZER, SliderForArgumentSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_ARGUMENT_SERIALIZER, ListForArgumentSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_ARGUMENT_SERIALIZER, TextFieldForArgumentSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_ARGUMENT_SERIALIZER, NumberFieldForArgumentSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_ARGUMENTS_ITEM_SERIALIZER, MultiArgCommandArgumentsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_ARGUMENT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_ARGUMENT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_ARGUMENT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_ARGUMENT_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_SERIALIZER, MultiArgCommandSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_ARGUMENTS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_ACTIONS_ITEM_SERIALIZER, AutomationForCapabilityActionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_SERIALIZER, AutomationForCapabilitySerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_CONDITIONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_ACTIONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER, SliderForAutomationConditionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER, ListForAutomationConditionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_VALUE_MAP_TRANSFORMER, SupportedValuesForDynamicListValueMapTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_TRANSFORMER, SupportedValuesForDynamicListTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_VALUE_MAP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER, DynamicListForAutomationConditionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER, NumberFieldForAutomationConditionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER, TextFieldForAutomationConditionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SUPPORTED_OPERATORS_ITEM_TRANSFORMER, EnumSliderForAutomationConditionSupportedOperatorsItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER, EnumSliderForAutomationConditionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_SUPPORTED_OPERATORS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_CONDITIONS_ITEM_TRANSFORMER, AutomationForCapabilityConditionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_TRANSFORMER, SliderForAutomationActionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER, ListForAutomationActionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER, DynamicListForAutomationActionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SUPPORTED_VALUES_FOR_DYNAMIC_LIST_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER, TextFieldForAutomationActionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER, NumberFieldForAutomationActionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_ARGUMENT_TRANSFORMER, SliderForArgumentTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_ARGUMENT_TRANSFORMER, ListForArgumentTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_ARGUMENT_TRANSFORMER, TextFieldForArgumentTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_ARGUMENT_TRANSFORMER, NumberFieldForArgumentTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_ARGUMENTS_ITEM_TRANSFORMER, MultiArgCommandArgumentsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_ARGUMENT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_ARGUMENT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_ARGUMENT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_ARGUMENT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_TRANSFORMER, MultiArgCommandTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_ARGUMENTS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_ACTIONS_ITEM_TRANSFORMER, AutomationForCapabilityActionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_TRANSFORMER, AutomationForCapabilityTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_CONDITIONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_ACTIONS_ITEM_TRANSFORMER),
                ]
            );
    }
}
