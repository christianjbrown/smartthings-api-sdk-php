<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForPanelSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializer;
use ChristianBrown\SmartThings\Serializer\DescriptionItemSerializer;
use ChristianBrown\SmartThings\Serializer\DescriptionsInAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardActionInlineSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardActionSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemArgumentsItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfosItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemBadgeItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemProductKeysItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdExcludeItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemAttributesItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceActionConfigEntrySerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceConditionConfigEntrySerializer;
use ChristianBrown\SmartThings\Serializer\GroupVisibleConditionsSerializer;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigItemsItemSerializer;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigSerializer;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForPanelTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformer;
use ChristianBrown\SmartThings\Transformer\CreateDeviceConfigRequestTransformer;
use ChristianBrown\SmartThings\Transformer\DescriptionItemTransformer;
use ChristianBrown\SmartThings\Transformer\DescriptionsInAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardActionInlineTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardActionTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemArgumentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfosItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemBadgeItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemProductKeysItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationRequestAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdExcludeItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemAttributesItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceActionConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceConditionConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\GroupVisibleConditionsTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigItemsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigTransformer;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DeviceConfigurationShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_AUTOMATION_SERIALIZER, DeviceConfigurationAutomationSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_AUTOMATION_TRANSFORMER, DeviceConfigurationAutomationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_SERIALIZER, DeviceConfigurationSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_AUTOMATION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_TRANSFORMER, DeviceConfigurationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_AUTOMATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_SERIALIZER, DeviceConfigurationRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_DASHBOARD_STATE_SERIALIZER, CapabilityValueForDashboardStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_DASHBOARD_STATE_TRANSFORMER, CapabilityValueForDashboardStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_SERIALIZER, DeviceConfigEntryForDashboardStateSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_DASHBOARD_STATE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_TRANSFORMER, DeviceConfigEntryForDashboardStateTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_DASHBOARD_STATE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_INLINE_SERIALIZER, DeviceConfigEntryForDashboardActionInlineSerializer::class)
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
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_INLINE_TRANSFORMER, DeviceConfigEntryForDashboardActionInlineTransformer::class)
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
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_SERIALIZER, DeviceConfigEntryForDashboardActionSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_INLINE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_TRANSFORMER, DeviceConfigEntryForDashboardActionTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_INLINE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_PANEL_SERIALIZER, CapabilityValueForPanelSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_PANEL_TRANSFORMER, CapabilityValueForPanelTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_ITEMS_ITEM_SERIALIZER, PanelForDeviceConfigItemsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_PANEL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_ITEMS_ITEM_TRANSFORMER, PanelForDeviceConfigItemsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_PANEL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_SERIALIZER, PanelForDeviceConfigSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_ITEMS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_TRANSFORMER, PanelForDeviceConfigTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_ITEMS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_SERIALIZER, DeviceConfigurationDashboardSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_TRANSFORMER, DeviceConfigurationDashboardTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_SERIALIZER, CapabilityValueSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_TRANSFORMER, CapabilityValueTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_PATCH_ITEM_SERIALIZER, PatchItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PATCH_ITEM_TRANSFORMER, PatchItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_SERIALIZER, DeviceConfigEntryForDetailViewSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PATCH_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_TRANSFORMER, DeviceConfigEntryForDetailViewTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PATCH_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_SERIALIZER, ExcludedConditionItemIdSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_TRANSFORMER, ExcludedConditionItemIdTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_SERIALIZER, ExcludedDeviceConditionConfigEntrySerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PATCH_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_TRANSFORMER, ExcludedDeviceConditionConfigEntryTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PATCH_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_SERIALIZER, ExcludedActionItemIdSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_TRANSFORMER, ExcludedActionItemIdTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_SERIALIZER, ExcludedDeviceActionConfigEntrySerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PATCH_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_TRANSFORMER, ExcludedDeviceActionConfigEntryTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PATCH_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_SERIALIZER, DeviceConfigurationRequestAutomationSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_TRANSFORMER, DeviceConfigurationRequestAutomationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CREATE_DEVICE_CONFIG_REQUEST_TRANSFORMER, CreateDeviceConfigRequestTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER, VisibleConditionSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER, VisibleConditionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_BADGE_ITEM_SERIALIZER, DeviceConfigurationIconsItemBadgeItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_BADGE_ITEM_TRANSFORMER, DeviceConfigurationIconsItemBadgeItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_PRODUCT_KEYS_ITEM_SERIALIZER, DeviceConfigurationIconsItemProductKeysItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_PRODUCT_KEYS_ITEM_TRANSFORMER, DeviceConfigurationIconsItemProductKeysItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_SERIALIZER, DeviceConfigurationIconsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_BADGE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_PRODUCT_KEYS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_TRANSFORMER, DeviceConfigurationIconsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_BADGE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_PRODUCT_KEYS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_SERIALIZER, VisibleConditionForDashboardStateSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER, VisibleConditionForDashboardStateTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_REMAINING_TIME_SERIALIZER, DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_REMAINING_TIME_TRANSFORMER, DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TIME_SERIALIZER, DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TIME_TRANSFORMER, DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER, DeviceConfigEntryForDashboardStateFormatInfoItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_REMAINING_TIME_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TIME_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER, DeviceConfigEntryForDashboardStateFormatInfoItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_REMAINING_TIME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TIME_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER, GroupVisibleConditionsSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER, GroupVisibleConditionsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER, VisibleConditionForDetailViewSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER, VisibleConditionForDetailViewTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_SERIALIZER, DeviceConfigurationDpInfoItemArgumentsItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_TRANSFORMER, DeviceConfigurationDpInfoItemArgumentsItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_SERIALIZER, ExcludedConditionItemIdExcludeItemAttributesItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_TRANSFORMER, ExcludedConditionItemIdExcludeItemAttributesItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_SERIALIZER, ExcludedConditionItemIdExcludeItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER, ExcludedConditionItemIdExcludeItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_SERIALIZER, ExcludedActionItemIdExcludeItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER, ExcludedActionItemIdExcludeItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DESCRIPTION_ITEM_SERIALIZER, DescriptionItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DESCRIPTION_ITEM_TRANSFORMER, DescriptionItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_SERIALIZER, DescriptionsInAutomationSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DESCRIPTION_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_TRANSFORMER, DescriptionsInAutomationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DESCRIPTION_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_SERIALIZER, DeviceConfigurationDpInfoItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_TRANSFORMER, DeviceConfigurationDpInfoItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_SERIALIZER, DeviceConfigurationDpInfosItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_TRANSFORMER, DeviceConfigurationDpInfosItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_TRANSFORMER),
                ]
            );
    }
}
