<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ActionItemSerializer;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\EmptyWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\ListForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeStateSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldSerializer;
use ChristianBrown\SmartThings\Serializer\PanelItemForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseCommandSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseStateSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopCommandSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopStateSerializer;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsSerializer;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsTemperatureConversionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\PushButtonSerializer;
use ChristianBrown\SmartThings\Serializer\PushButtonWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\SliderTypeSerializer;
use ChristianBrown\SmartThings\Serializer\SliderWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchSerializer;
use ChristianBrown\SmartThings\Serializer\StateItemSerializer;
use ChristianBrown\SmartThings\Serializer\StatelessPowerToggleForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\StateSerializer;
use ChristianBrown\SmartThings\Serializer\StateWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\StepperSerializer;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeStateSerializer;
use ChristianBrown\SmartThings\Serializer\SwitchControlSerializer;
use ChristianBrown\SmartThings\Serializer\SwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\TextButtonButtonsItemSerializer;
use ChristianBrown\SmartThings\Serializer\TextButtonSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardCommandSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ActionItemTransformer;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CreateCapabilityPresentationRequestDetailViewItemTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\EmptyWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\ListForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldTransformer;
use ChristianBrown\SmartThings\Transformer\PanelItemForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseCommandTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseStateTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopCommandTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopStateTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTemperatureConversionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\SliderTypeTransformer;
use ChristianBrown\SmartThings\Transformer\SliderWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchTransformer;
use ChristianBrown\SmartThings\Transformer\StateItemTransformer;
use ChristianBrown\SmartThings\Transformer\StatelessPowerToggleForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\StateTransformer;
use ChristianBrown\SmartThings\Transformer\StateWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\StepperTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchControlTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\TextButtonButtonsItemTransformer;
use ChristianBrown\SmartThings\Transformer\TextButtonTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CapabilityPresentationShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_SERIALIZER, CreateCapabilityPresentationRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER, AlternativeItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_STATE_ITEM_SERIALIZER, StateItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PUSH_BUTTON_SERIALIZER, PushButtonSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER, ToggleSwitchForDashboardCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER, ToggleSwitchForDashboardStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_SERIALIZER, ToggleSwitchForDashboardSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_SERIALIZER, SwitchForDashboardSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER, StandbyPowerSwitchForDashboardStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_SERIALIZER, StandbyPowerSwitchForDashboardSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_SERIALIZER, StatelessPowerToggleForDashboardSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAY_PAUSE_COMMAND_SERIALIZER, PlayPauseCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAY_PAUSE_STATE_SERIALIZER, PlayPauseStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PLAY_PAUSE_SERIALIZER, PlayPauseSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PLAY_STOP_COMMAND_SERIALIZER, PlayStopCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAY_STOP_STATE_SERIALIZER, PlayStopStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PLAY_STOP_SERIALIZER, PlayStopSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ACTION_ITEM_SERIALIZER, ActionItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER, StepperWithAvailableSizeCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_STATE_SERIALIZER, StepperWithAvailableSizeStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_SERIALIZER, StepperWithAvailableSizeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER, ListWithAvailableSizeCommandSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_SERIALIZER, ListWithAvailableSizeStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_SERIALIZER, ListWithAvailableSizeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PUSH_BUTTON_WITH_AVAILABLE_SIZE_SERIALIZER, PushButtonWithAvailableSizeSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_STATE_WITH_AVAILABLE_SIZE_SERIALIZER, StateWithAvailableSizeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_WITH_AVAILABLE_SIZE_SERIALIZER, SliderWithAvailableSizeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EMPTY_WITH_AVAILABLE_SIZE_SERIALIZER, EmptyWithAvailableSizeSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PANEL_ITEM_FOR_CAPABILITY_SERIALIZER, PanelItemForCapabilitySerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_WITH_AVAILABLE_SIZE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STATE_WITH_AVAILABLE_SIZE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_WITH_AVAILABLE_SIZE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_EMPTY_WITH_AVAILABLE_SIZE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_SERIALIZER, DashboardForCapabilitySerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STATE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_ACTION_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_ITEM_FOR_CAPABILITY_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_SERIALIZER, ToggleSwitchSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_SERIALIZER, StandbyPowerSwitchSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SWITCH_CONTROL_SERIALIZER, SwitchControlSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_TYPE_SERIALIZER, SliderTypeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_BUTTON_BUTTONS_ITEM_SERIALIZER, TextButtonButtonsItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_TEXT_BUTTON_SERIALIZER, TextButtonSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TEXT_BUTTON_BUTTONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_DETAIL_VIEW_SERIALIZER, ListForDetailViewSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_SERIALIZER, TextFieldSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_SERIALIZER, NumberFieldSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_STEPPER_SERIALIZER, StepperSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STATE_SERIALIZER, StateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_SERIALIZER, VisibleConditionBaseSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_SERIALIZER, CreateCapabilityPresentationRequestDetailViewItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_SWITCH_CONTROL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_TYPE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_BUTTON_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_FOR_DETAIL_VIEW_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_TEXT_FIELD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_NUMBER_FIELD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_STATE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_SERIALIZER, PresentationSettingsTemperatureConversionsItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_SERIALIZER, PresentationSettingsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_UPDATE_CAPABILITY_PRESENTATION_REQUEST_SERIALIZER, UpdateCapabilityPresentationRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER, AlternativeItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_STATE_ITEM_TRANSFORMER, StateItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PUSH_BUTTON_TRANSFORMER, PushButtonTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER, ToggleSwitchForDashboardCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER, ToggleSwitchForDashboardStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_TRANSFORMER, ToggleSwitchForDashboardTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_TRANSFORMER, SwitchForDashboardTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER, StandbyPowerSwitchForDashboardStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_TRANSFORMER, StandbyPowerSwitchForDashboardTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_TRANSFORMER, StatelessPowerToggleForDashboardTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAY_PAUSE_COMMAND_TRANSFORMER, PlayPauseCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAY_PAUSE_STATE_TRANSFORMER, PlayPauseStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PLAY_PAUSE_TRANSFORMER, PlayPauseTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PLAY_STOP_COMMAND_TRANSFORMER, PlayStopCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAY_STOP_STATE_TRANSFORMER, PlayStopStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PLAY_STOP_TRANSFORMER, PlayStopTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ACTION_ITEM_TRANSFORMER, ActionItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_PAUSE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PLAY_STOP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER, StepperWithAvailableSizeCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER, StepperWithAvailableSizeStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_TRANSFORMER, StepperWithAvailableSizeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER, ListWithAvailableSizeCommandTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER, ListWithAvailableSizeStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_TRANSFORMER, ListWithAvailableSizeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PUSH_BUTTON_WITH_AVAILABLE_SIZE_TRANSFORMER, PushButtonWithAvailableSizeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_STATE_WITH_AVAILABLE_SIZE_TRANSFORMER, StateWithAvailableSizeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_WITH_AVAILABLE_SIZE_TRANSFORMER, SliderWithAvailableSizeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EMPTY_WITH_AVAILABLE_SIZE_TRANSFORMER, EmptyWithAvailableSizeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PANEL_ITEM_FOR_CAPABILITY_TRANSFORMER, PanelItemForCapabilityTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PUSH_BUTTON_WITH_AVAILABLE_SIZE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STATE_WITH_AVAILABLE_SIZE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_WITH_AVAILABLE_SIZE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EMPTY_WITH_AVAILABLE_SIZE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_TRANSFORMER, DashboardForCapabilityTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STATE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ACTION_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_ITEM_FOR_CAPABILITY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_TRANSFORMER, ToggleSwitchTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_TRANSFORMER, StandbyPowerSwitchTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SWITCH_CONTROL_TRANSFORMER, SwitchControlTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_TYPE_TRANSFORMER, SliderTypeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_BUTTON_BUTTONS_ITEM_TRANSFORMER, TextButtonButtonsItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_TEXT_BUTTON_TRANSFORMER, TextButtonTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TEXT_BUTTON_BUTTONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LIST_FOR_DETAIL_VIEW_TRANSFORMER, ListForDetailViewTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_TEXT_FIELD_TRANSFORMER, TextFieldTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_NUMBER_FIELD_TRANSFORMER, NumberFieldTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_STEPPER_TRANSFORMER, StepperTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_STATE_TRANSFORMER, StateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_TRANSFORMER, VisibleConditionBaseTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_TRANSFORMER, CreateCapabilityPresentationRequestDetailViewItemTransformer::class)
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
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_TRANSFORMER, PresentationSettingsTemperatureConversionsItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TRANSFORMER, PresentationSettingsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_PRESENTATION_DETAILS_TRANSFORMER, CapabilityPresentationDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_FOR_CAPABILITY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TRANSFORMER),
                ]
            );
    }
}
