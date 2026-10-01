<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceConfigurationShapeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DeviceConfigurationShapeRegistrar::class)]
final class DeviceConfigurationShapeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new DeviceConfigurationShapeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_AUTOMATION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_AUTOMATION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_DASHBOARD_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_DASHBOARD_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_INLINE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_INLINE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_ACTION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_PANEL_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_FOR_PANEL_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_ITEMS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_ITEMS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CAPABILITY_VALUE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PATCH_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_PATCH_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_CONDITION_CONFIG_ENTRY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_DEVICE_ACTION_CONFIG_ENTRY_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_CREATE_DEVICE_CONFIG_REQUEST_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_BADGE_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_BADGE_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_PRODUCT_KEYS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_PRODUCT_KEYS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_REMAINING_TIME_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_REMAINING_TIME_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TIME_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TIME_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_ATTRIBUTES_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_CONDITION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EXCLUDED_ACTION_ITEM_ID_EXCLUDE_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DESCRIPTION_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DESCRIPTION_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFOS_ITEM_TRANSFORMER));
    }
}
