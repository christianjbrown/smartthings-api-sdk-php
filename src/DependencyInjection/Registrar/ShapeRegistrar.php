<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformer;
use ChristianBrown\SmartThings\Transformer\BleD2DDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ClustersTransformer;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformer;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformer;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRelationshipTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceResultsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DriverDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DriverFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformer;
use ChristianBrown\SmartThings\Transformer\DthDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeChildDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemComponentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\HubDriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\IconImageTransformer;
use ChristianBrown\SmartThings\Transformer\IdLessHealthStateTransformer;
use ChristianBrown\SmartThings\Transformer\IndoorMapTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppIconImageTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppUiTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsFunctionCodesTransformer;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LambdaSmartAppTransformer;
use ChristianBrown\SmartThings\Transformer\LanDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationParentTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointDeviceTypeTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointTransformer;
use ChristianBrown\SmartThings\Transformer\MatterVersionTransformer;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\MqttDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\NoticeTransformer;
use ChristianBrown\SmartThings\Transformer\OcfDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\OwnerTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinksTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinkTransformer;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformer;
use ChristianBrown\SmartThings\Transformer\RoomIndoorMapTransformer;
use ChristianBrown\SmartThings\Transformer\SceneLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteAcceptanceTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInvitePageTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteReceiptTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteStatusTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteTransformer;
use ChristianBrown\SmartThings\Transformer\SecurityArmStateDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemLastUpdateTimeTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemSeverityTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformer;
use ChristianBrown\SmartThings\Transformer\TtsVoiceTransformer;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformer;
use ChristianBrown\SmartThings\Transformer\ViperDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\VirtualDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\WebhookSmartAppTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeGenericFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeManufacturerFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZwaveDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ZWaveGenericFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZWaveManufacturerFingerprintTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_TTS_VOICE_TRANSFORMER, TtsVoiceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_TTS_INFO_TRANSFORMER, TtsInfoTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TTS_VOICE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CONVERTED_TTS_TRANSFORMER, ConvertedTtsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAYED_TEXT_TRANSFORMER, PlayedTextTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_RECEIPT_TRANSFORMER, SchemaAppInviteReceiptTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_ACCEPTANCE_TRANSFORMER, SchemaAppInviteAcceptanceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_TRANSFORMER, SchemaAppInviteTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PAGE_LINK_TRANSFORMER, PageLinkTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PAGE_LINKS_TRANSFORMER, PageLinksTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PAGE_LINK_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_PAGE_TRANSFORMER, SchemaAppInvitePageTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PAGE_LINKS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_INVITE_STATUS_TRANSFORMER, SchemaAppInviteStatusTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_PARENT_TRANSFORMER, LocationParentTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_DETAILS_TRANSFORMER, LocationDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_LOCATION_PARENT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ROOM_INDOOR_MAP_TRANSFORMER, RoomIndoorMapTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ROOM_DETAILS_TRANSFORMER, LocationRoomDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ROOM_INDOOR_MAP_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CRON_SCHEDULE_TRANSFORMER, CronScheduleTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEDULE_DETAILS_TRANSFORMER, ScheduleDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CRON_SCHEDULE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_LAST_UPDATE_TIME_TRANSFORMER, ServiceCapabilityDataAlertItemLastUpdateTimeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_SEVERITY_TRANSFORMER, ServiceCapabilityDataAlertItemSeverityTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_TRANSFORMER, ServiceCapabilityDataAlertItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_LAST_UPDATE_TIME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_SEVERITY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_DETAILS_TRANSFORMER, ServiceCapabilityDataDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SERVICE_CAPABILITY_DATA_ALERT_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER, DeviceIntegrationProfileKeyTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DRIVER_PERMISSION_TRANSFORMER, DriverPermissionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CLUSTERS_TRANSFORMER, ClustersTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ZIGBEE_GENERIC_FINGERPRINT_TRANSFORMER, ZigbeeGenericFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CLUSTERS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ZIGBEE_MANUFACTURER_FINGERPRINT_TRANSFORMER, ZigbeeManufacturerFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ZWAVE_MANUFACTURER_FINGERPRINT_TRANSFORMER, ZWaveManufacturerFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_COMMAND_CLASSES_TRANSFORMER, CommandClassesTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ZWAVE_GENERIC_FINGERPRINT_TRANSFORMER, ZWaveGenericFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_COMMAND_CLASSES_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DRIVER_FINGERPRINT_TRANSFORMER, DriverFingerprintTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ZIGBEE_GENERIC_FINGERPRINT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZIGBEE_MANUFACTURER_FINGERPRINT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZWAVE_MANUFACTURER_FINGERPRINT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZWAVE_GENERIC_FINGERPRINT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DRIVER_DETAILS_TRANSFORMER, DriverDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_INTEGRATION_PROFILE_KEY_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DRIVER_PERMISSION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DRIVER_FINGERPRINT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VIPER_APP_LINKS_TRANSFORMER, ViperAppLinksTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEMA_APP_DETAILS_TRANSFORMER, SchemaAppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VIPER_APP_LINKS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_DEVICE_RESULTS_TRANSFORMER, DeviceResultsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_SCHEMA_APP_DETAILS_TRANSFORMER, InstalledSchemaAppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_RESULTS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VIPER_APP_LINKS_TRANSFORMER),
                ]
            );
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
        $container->register(SmartThingsInterface::SERVICE_OWNER_TRANSFORMER, OwnerTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_NOTICE_TRANSFORMER, NoticeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_UI_TRANSFORMER, InstalledAppUiTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_ICON_IMAGE_TRANSFORMER, InstalledAppIconImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INSTALLED_APP_DETAILS_TRANSFORMER, InstalledAppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_OWNER_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_NOTICE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_INSTALLED_APP_UI_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_INSTALLED_APP_ICON_IMAGE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ICON_IMAGE_TRANSFORMER, IconImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LAMBDA_SMART_APP_TRANSFORMER, LambdaSmartAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_WEBHOOK_SMART_APP_TRANSFORMER, WebhookSmartAppTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_UI_SETTINGS_TRANSFORMER, AppUiSettingsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_DETAILS_TRANSFORMER, AppDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ICON_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_OWNER_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LAMBDA_SMART_APP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_WEBHOOK_SMART_APP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_APP_UI_SETTINGS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ID_LESS_HEALTH_STATE_TRANSFORMER, IdLessHealthStateTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_PROFILE_REFERENCE_TRANSFORMER, DeviceProfileReferenceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_APP_DEVICE_DETAILS_TRANSFORMER, AppDeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PROFILE_REFERENCE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BLE_D2_DDEVICE_DETAILS_TRANSFORMER, BleD2DDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DTH_DEVICE_DETAILS_TRANSFORMER, DthDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_LAN_DEVICE_DETAILS_TRANSFORMER, LanDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ZIGBEE_DEVICE_DETAILS_TRANSFORMER, ZigbeeDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_ZWAVE_DEVICE_DETAILS_TRANSFORMER, ZwaveDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_MATTER_VERSION_TRANSFORMER, MatterVersionTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_MATTER_ENDPOINT_DEVICE_TYPE_TRANSFORMER, MatterEndpointDeviceTypeTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_MATTER_ENDPOINT_TRANSFORMER, MatterEndpointTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_MATTER_ENDPOINT_DEVICE_TYPE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_MATTER_DEVICE_DETAILS_TRANSFORMER, MatterDeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_MATTER_VERSION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MATTER_ENDPOINT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_HUB_DRIVER_TRANSFORMER, HubDriverTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS_APPS_ITEM_TRANSFORMER, EdgeDriverSupportedEndpointAppsAppsItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS_TRANSFORMER, EdgeDriverSupportedEndpointAppsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS_APPS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_HUB2HUB_SUPPORT_MATRIX_CAPABILITIES_ITEM_TRANSFORMER, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_HUB2HUB_SUPPORT_MATRIX_TRANSFORMER, HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_HUB2HUB_SUPPORT_MATRIX_CAPABILITIES_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_TRANSFORMER, HubDeviceDetailsHubDataTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_HUB2HUB_SUPPORT_MATRIX_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_TRANSFORMER, HubDeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_HUB_DRIVER_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_EDGE_CHILD_DEVICE_DETAILS_TRANSFORMER, EdgeChildDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_IR_DEVICE_DETAILS_FUNCTION_CODES_TRANSFORMER, IrDeviceDetailsFunctionCodesTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_IR_DEVICE_DETAILS_TRANSFORMER, IrDeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_IR_DEVICE_DETAILS_FUNCTION_CODES_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_OCF_DEVICE_DETAILS_TRANSFORMER, OcfDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VIPER_DEVICE_DETAILS_TRANSFORMER, ViperDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_DEVICES_ITEM_COMPONENTS_ITEM_TRANSFORMER, GroupDeviceDetailsDevicesItemComponentsItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_DEVICES_ITEM_TRANSFORMER, GroupDeviceDetailsDevicesItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_DEVICES_ITEM_COMPONENTS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_TRANSFORMER, GroupDeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_DEVICES_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ATTRIBUTE_VALUE_TRANSFORMER, AttributeValueTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_COMMAND_MAPPING_TRANSFORMER, CommandMappingTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ATTRIBUTE_VALUE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_COMMAND_MAPPINGS_TRANSFORMER, CommandMappingsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_COMMAND_MAPPING_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_DETAILS_TRANSFORMER, VirtualDeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_COMMAND_MAPPINGS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_MQTT_DEVICE_DETAILS_TRANSFORMER, MqttDeviceDetailsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_INDOOR_MAP_TRANSFORMER, IndoorMapTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_RELATIONSHIP_TRANSFORMER, DeviceRelationshipTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_DETAILS_TRANSFORMER, DeviceDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ID_LESS_HEALTH_STATE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_PROFILE_REFERENCE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_APP_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BLE_D2_DDEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DTH_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LAN_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZIGBEE_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ZWAVE_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MATTER_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_EDGE_CHILD_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_IR_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_OCF_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VIPER_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_MQTT_DEVICE_DETAILS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_INDOOR_MAP_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_RELATIONSHIP_TRANSFORMER),
                ]
            );
    }
}
