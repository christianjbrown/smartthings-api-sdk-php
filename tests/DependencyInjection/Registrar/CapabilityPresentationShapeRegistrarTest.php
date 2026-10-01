<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityPresentationShapeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CapabilityPresentationShapeRegistrar::class)]
final class CapabilityPresentationShapeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new CapabilityPresentationShapeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATE_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PUSH_BUTTON_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_PAUSE_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_PAUSE_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_PAUSE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_STOP_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_STOP_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_STOP_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PUSH_BUTTON_WITH_AVAILABLE_SIZE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATE_WITH_AVAILABLE_SIZE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_WITH_AVAILABLE_SIZE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EMPTY_WITH_AVAILABLE_SIZE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PANEL_ITEM_FOR_CAPABILITY_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SWITCH_CONTROL_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_TYPE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_BUTTON_BUTTONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_BUTTON_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_DETAIL_VIEW_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_UPDATE_CAPABILITY_PRESENTATION_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATE_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PUSH_BUTTON_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_FOR_DASHBOARD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SWITCH_FOR_DASHBOARD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_FOR_DASHBOARD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATELESS_POWER_TOGGLE_FOR_DASHBOARD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_PAUSE_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_PAUSE_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_PAUSE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_STOP_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_STOP_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PLAY_STOP_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ACTION_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_WITH_AVAILABLE_SIZE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_WITH_AVAILABLE_SIZE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PUSH_BUTTON_WITH_AVAILABLE_SIZE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATE_WITH_AVAILABLE_SIZE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_WITH_AVAILABLE_SIZE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EMPTY_WITH_AVAILABLE_SIZE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PANEL_ITEM_FOR_CAPABILITY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DASHBOARD_FOR_CAPABILITY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TOGGLE_SWITCH_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STANDBY_POWER_SWITCH_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SWITCH_CONTROL_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_TYPE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_BUTTON_BUTTONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_BUTTON_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LIST_FOR_DETAIL_VIEW_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_TEXT_FIELD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_NUMBER_FIELD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STEPPER_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_BASE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CREATE_CAPABILITY_PRESENTATION_REQUEST_DETAIL_VIEW_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_PRESENTATION_DETAILS_TRANSFORMER));
    }
}
