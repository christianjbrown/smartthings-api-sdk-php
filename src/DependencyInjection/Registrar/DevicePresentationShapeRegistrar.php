<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ActionListItemTransformer;
use ChristianBrown\SmartThings\Transformer\ActionsArrayItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationListItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemForPresentationTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardTransformer;
use ChristianBrown\SmartThings\Transformer\DetailViewListItemTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemTransformer;
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationItemsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\StateForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\StatesArrayItemTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemCommandTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemStateTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\TemperatureConversionsItemForDevicePresentationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DevicePresentationShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_STATES_ARRAY_ITEM_TRANSFORMER, StatesArrayItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ACTIONS_ARRAY_ITEM_TRANSFORMER, ActionsArrayItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STEPPER_FOR_PANEL_ITEM_COMMAND_TRANSFORMER, StepperForPanelItemCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_STEPPER_FOR_PANEL_ITEM_STATE_TRANSFORMER, StepperForPanelItemStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STEPPER_FOR_PANEL_ITEM_TRANSFORMER, StepperForPanelItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_FOR_PANEL_ITEM_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_FOR_PANEL_ITEM_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_PANEL_ITEM_COMMAND_TRANSFORMER, ListForPanelItemCommandTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_PANEL_ITEM_STATE_TRANSFORMER, ListForPanelItemStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_PANEL_ITEM_TRANSFORMER, ListForPanelItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_PANEL_ITEM_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_PANEL_ITEM_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PUSH_BUTTON_FOR_PANEL_ITEM_TRANSFORMER, PushButtonForPanelItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_STATE_FOR_PANEL_ITEM_TRANSFORMER, StateForPanelItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_PANEL_ITEM_TRANSFORMER, SliderForPanelItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EMPTY_FOR_PANEL_ITEM_TRANSFORMER, EmptyForPanelItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_PRESENTATION_ITEMS_ITEM_TRANSFORMER, PanelForDevicePresentationItemsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_FOR_PANEL_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_PANEL_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_FOR_PANEL_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STATE_FOR_PANEL_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_PANEL_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EMPTY_FOR_PANEL_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_PRESENTATION_TRANSFORMER, PanelForDevicePresentationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_PRESENTATION_ITEMS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_FOR_PRESENTATION_TRANSFORMER, BasicPlusItemForPresentationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_PRESENTATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DASHBOARD_TRANSFORMER, DashboardTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STATES_ARRAY_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ACTIONS_ARRAY_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_FOR_PRESENTATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DETAIL_VIEW_LIST_ITEM_TRANSFORMER, DetailViewListItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SWITCH_CONTROL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_TYPE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_BUTTON_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_DETAIL_VIEW_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STATE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_TRANSFORMER, ExcludedConditionItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_LIST_ITEM_TRANSFORMER, AutomationListItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ENUM_SLIDER_FOR_AUTOMATION_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_TRANSFORMER, ExcludedActionItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ACTION_LIST_ITEM_TRANSFORMER, ActionListItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DYNAMIC_LIST_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_FOR_AUTOMATION_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MULTI_ARG_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_TRANSFORMER, AutomationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_LIST_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ACTION_LIST_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PO_CODES_TRANSFORMER, PoCodesTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LANGUAGE_ITEM_TRANSFORMER, LanguageItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PO_CODES_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEMPERATURE_CONVERSIONS_ITEM_FOR_DEVICE_PRESENTATION_TRANSFORMER, TemperatureConversionsItemForDevicePresentationTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_FOR_DEVICE_PRESENTATION_TRANSFORMER, PresentationSettingsForDevicePresentationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TEMPERATURE_CONVERSIONS_ITEM_FOR_DEVICE_PRESENTATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PRESENTATION_TRANSFORMER, DevicePresentationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DETAIL_VIEW_LIST_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LANGUAGE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_FOR_DEVICE_PRESENTATION_TRANSFORMER),
                ]
            );
    }
}
