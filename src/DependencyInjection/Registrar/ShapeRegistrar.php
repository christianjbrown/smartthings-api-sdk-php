<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ActionItemSerializer;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityConditionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationValueSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityReferenceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCategorySerializer;
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EmptyWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSupportedOperatorsItemSerializer;
use ChristianBrown\SmartThings\Serializer\ListForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\ListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\ListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\ListForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeStateSerializer;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandArgumentsItemSerializer;
use ChristianBrown\SmartThings\Serializer\MultiArgCommandSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldSerializer;
use ChristianBrown\SmartThings\Serializer\PanelItemForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseCommandSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseStateSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopCommandSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopStateSerializer;
use ChristianBrown\SmartThings\Serializer\PreferenceDefinitionSerializer;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsSerializer;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsTemperatureConversionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\PushButtonSerializer;
use ChristianBrown\SmartThings\Serializer\PushButtonWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\RestrictionSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationConditionSerializer;
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
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListSerializer;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListValueMapSerializer;
use ChristianBrown\SmartThings\Serializer\SwitchControlSerializer;
use ChristianBrown\SmartThings\Serializer\SwitchForDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\TextButtonButtonsItemSerializer;
use ChristianBrown\SmartThings\Serializer\TextButtonSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationConditionSerializer;
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
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityConditionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\BleD2DDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ClustersTransformer;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformer;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformer;
use ChristianBrown\SmartThings\Transformer\CreateCapabilityPresentationRequestDetailViewItemTransformer;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCapabilityReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRelationshipTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRestrictionTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceResultsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DriverDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DriverFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformer;
use ChristianBrown\SmartThings\Transformer\DthDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeChildDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformer;
use ChristianBrown\SmartThings\Transformer\EmptyWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformer;
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
use ChristianBrown\SmartThings\Transformer\ListForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationParentTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointDeviceTypeTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointTransformer;
use ChristianBrown\SmartThings\Transformer\MatterVersionTransformer;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\MqttDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandArgumentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformer;
use ChristianBrown\SmartThings\Transformer\NoticeTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldTransformer;
use ChristianBrown\SmartThings\Transformer\OcfDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\OwnerTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinksTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinkTransformer;
use ChristianBrown\SmartThings\Transformer\PanelItemForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformer;
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
use ChristianBrown\SmartThings\Transformer\RestrictionTransformer;
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
use ChristianBrown\SmartThings\Transformer\SliderForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationConditionTransformer;
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
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchControlTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\TextButtonButtonsItemTransformer;
use ChristianBrown\SmartThings\Transformer\TextButtonTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchTransformer;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformer;
use ChristianBrown\SmartThings\Transformer\TtsVoiceTransformer;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformer;
use ChristianBrown\SmartThings\Transformer\ViperDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\VirtualDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformer;
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
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_SERIALIZER, PresentationSettingsTemperatureConversionsItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_SERIALIZER, PresentationSettingsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PRESENTATION_SETTINGS_TEMPERATURE_CONVERSIONS_ITEM_SERIALIZER),
                ]
            );
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
