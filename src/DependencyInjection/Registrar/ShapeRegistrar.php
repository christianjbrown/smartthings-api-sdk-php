<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ActionItemSerializer;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilityConditionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraImageSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraOverlayIconsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemProgressBarsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlColorSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsBarItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsStateItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardColorsSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvChannelSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadCommandSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeSerializer;
use ChristianBrown\SmartThings\Serializer\ButtonForTvSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityConfigurationValueSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityReferenceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForPanelSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\DescriptionItemSerializer;
use ChristianBrown\SmartThings\Serializer\DescriptionsInAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCategorySerializer;
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
use ChristianBrown\SmartThings\Serializer\DeviceProfileComponentRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationActionSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EmptyWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSupportedOperatorsItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdExcludeItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemAttributesItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceActionConfigEntrySerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceConditionConfigEntrySerializer;
use ChristianBrown\SmartThings\Serializer\GroupVisibleConditionsSerializer;
use ChristianBrown\SmartThings\Serializer\IndoorMapSerializer;
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
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigItemsItemSerializer;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigSerializer;
use ChristianBrown\SmartThings\Serializer\PanelItemForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializer;
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
use ChristianBrown\SmartThings\Serializer\SliderForLightSerializer;
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
use ChristianBrown\SmartThings\Serializer\UpdateDeviceComponentSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemReferToSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ActionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ActionListItemTransformer;
use ChristianBrown\SmartThings\Transformer\ActionsArrayItemTransformer;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformer;
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeDataSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributePropertiesTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeUnitSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityConditionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationListItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraImageTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemForPresentationTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemProgressBarsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlColorTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsBarItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsStateItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardColorsTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvChannelTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadCommandTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeTransformer;
use ChristianBrown\SmartThings\Transformer\BleD2DDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ButtonForTvTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLabelTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForPanelTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformer;
use ChristianBrown\SmartThings\Transformer\ClustersTransformer;
use ChristianBrown\SmartThings\Transformer\CommandArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformer;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformer;
use ChristianBrown\SmartThings\Transformer\CreateCapabilityPresentationRequestDetailViewItemTransformer;
use ChristianBrown\SmartThings\Transformer\CreateDeviceConfigRequestTransformer;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DashboardTransformer;
use ChristianBrown\SmartThings\Transformer\DescriptionItemTransformer;
use ChristianBrown\SmartThings\Transformer\DescriptionsInAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DetailViewListItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCapabilityReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformer;
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
use ChristianBrown\SmartThings\Transformer\DeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePresentationTransformer;
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
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\EmptyWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdExcludeItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemAttributesItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceActionConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceConditionConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemComponentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsDevicesItemTransformer;
use ChristianBrown\SmartThings\Transformer\GroupDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\GroupVisibleConditionsTransformer;
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
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformer;
use ChristianBrown\SmartThings\Transformer\ListForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\LocalizationDetailsTransformer;
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
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigItemsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDeviceConfigTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationItemsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PanelItemForCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformer;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseCommandTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseStateTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopCommandTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopStateTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformer;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformer;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTemperatureConversionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\PushButtonForPanelItemTransformer;
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
use ChristianBrown\SmartThings\Transformer\SliderForLightTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\SliderTypeTransformer;
use ChristianBrown\SmartThings\Transformer\SliderWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchTransformer;
use ChristianBrown\SmartThings\Transformer\StateForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\StateItemTransformer;
use ChristianBrown\SmartThings\Transformer\StatelessPowerToggleForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\StatesArrayItemTransformer;
use ChristianBrown\SmartThings\Transformer\StateTransformer;
use ChristianBrown\SmartThings\Transformer\StateWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemCommandTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemStateTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\StepperTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformer;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListValueMapTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchControlTransformer;
use ChristianBrown\SmartThings\Transformer\SwitchForDashboardTransformer;
use ChristianBrown\SmartThings\Transformer\TemperatureConversionsItemForDevicePresentationTransformer;
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
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemReferToTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformer;
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
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_SERIALIZER, DeviceConfigurationDpInfoItemArgumentsItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DP_INFO_ITEM_ARGUMENTS_ITEM_TRANSFORMER, DeviceConfigurationDpInfoItemArgumentsItemTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_SERIALIZER, VisibleConditionForDashboardStateSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER, VisibleConditionForDashboardStateTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER, BasicPlusCameraImageSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER, BasicPlusCameraImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER, BasicPlusCameraOverlayIconsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER, BasicPlusCameraOverlayIconsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER, BasicPlusCameraSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER, BasicPlusCameraTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER, BasicPlusTvVolumeCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER, BasicPlusTvVolumeCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER, BasicPlusTvVolumeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER, BasicPlusTvVolumeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER, ButtonForTvSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER, ButtonForTvTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER, BasicPlusTvChannelSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER, BasicPlusTvChannelTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER, BasicPlusTvDirectionalPadCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER, BasicPlusTvDirectionalPadCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER, BasicPlusTvDirectionalPadSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER, BasicPlusTvDirectionalPadTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER, BasicPlusTvSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER, BasicPlusTvTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER, SliderForLightSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER, SliderForLightTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER, BasicPlusLightColorControlColorSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER, BasicPlusLightColorControlColorTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER, BasicPlusLightColorControlSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER, BasicPlusLightColorControlTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER, BasicPlusLightSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER, BasicPlusLightTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER, BasicPlusItemActionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER, BasicPlusItemActionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER, VisibleConditionForColorItemReferToSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER, VisibleConditionForColorItemReferToTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER, VisibleConditionForColorItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER, VisibleConditionForColorItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER, BasicPlusStateBoardColorsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER, BasicPlusStateBoardColorsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER, BasicPlusStateBoardItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER, BasicPlusStateBoardItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER, BasicPlusProgressBarsStateItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER, BasicPlusProgressBarsStateItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER, BasicPlusProgressBarsBarItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER, BasicPlusProgressBarsBarItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER, BasicPlusItemProgressBarsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER, BasicPlusItemProgressBarsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER),
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_SERIALIZER, BasicPlusItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_TRANSFORMER, BasicPlusItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER, GroupVisibleConditionsSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER, GroupVisibleConditionsTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER, VisibleConditionForDetailViewSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER, VisibleConditionForDetailViewTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_SERIALIZER, VisibleConditionForDashboardStateSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER, VisibleConditionForDashboardStateTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER, BasicPlusCameraImageSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER, BasicPlusCameraImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER, BasicPlusCameraOverlayIconsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER, BasicPlusCameraOverlayIconsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER, BasicPlusCameraSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER, BasicPlusCameraTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER, BasicPlusTvVolumeCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER, BasicPlusTvVolumeCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER, BasicPlusTvVolumeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER, BasicPlusTvVolumeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER, ButtonForTvSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER, ButtonForTvTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER, BasicPlusTvChannelSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER, BasicPlusTvChannelTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER, BasicPlusTvDirectionalPadCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER, BasicPlusTvDirectionalPadCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER, BasicPlusTvDirectionalPadSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER, BasicPlusTvDirectionalPadTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER, BasicPlusTvSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER, BasicPlusTvTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER, SliderForLightSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER, SliderForLightTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER, BasicPlusLightColorControlColorSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER, BasicPlusLightColorControlColorTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER, BasicPlusLightColorControlSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER, BasicPlusLightColorControlTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER, BasicPlusLightSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER, BasicPlusLightTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER, BasicPlusItemActionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER, BasicPlusItemActionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER, VisibleConditionForColorItemReferToSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER, VisibleConditionForColorItemReferToTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER, VisibleConditionForColorItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER, VisibleConditionForColorItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER, BasicPlusStateBoardColorsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER, BasicPlusStateBoardColorsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER, BasicPlusStateBoardItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER, BasicPlusStateBoardItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER, BasicPlusProgressBarsStateItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER, BasicPlusProgressBarsStateItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER, BasicPlusProgressBarsBarItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER, BasicPlusProgressBarsBarItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER, BasicPlusItemProgressBarsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER, BasicPlusItemProgressBarsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER),
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_SERIALIZER, BasicPlusItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_TRANSFORMER, BasicPlusItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER, GroupVisibleConditionsSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER, GroupVisibleConditionsTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER, VisibleConditionForDetailViewSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER, VisibleConditionForDetailViewTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_SERIALIZER, DeviceConfigurationRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_ICONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_DASHBOARD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DETAIL_VIEW_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIGURATION_REQUEST_AUTOMATION_SERIALIZER),
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
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_SERIALIZER, VisibleConditionForDashboardStateSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DASHBOARD_STATE_TRANSFORMER, VisibleConditionForDashboardStateTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER, BasicPlusCameraImageSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER, BasicPlusCameraImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER, BasicPlusCameraOverlayIconsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER, BasicPlusCameraOverlayIconsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER, BasicPlusCameraSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER, BasicPlusCameraTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER, BasicPlusTvVolumeCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER, BasicPlusTvVolumeCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER, BasicPlusTvVolumeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER, BasicPlusTvVolumeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER, ButtonForTvSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER, ButtonForTvTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER, BasicPlusTvChannelSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER, BasicPlusTvChannelTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER, BasicPlusTvDirectionalPadCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER, BasicPlusTvDirectionalPadCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER, BasicPlusTvDirectionalPadSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER, BasicPlusTvDirectionalPadTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER, BasicPlusTvSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER, BasicPlusTvTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER, SliderForLightSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER, SliderForLightTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER, BasicPlusLightColorControlColorSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER, BasicPlusLightColorControlColorTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER, BasicPlusLightColorControlSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER, BasicPlusLightColorControlTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER, BasicPlusLightSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER, BasicPlusLightTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER, BasicPlusItemActionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER, BasicPlusItemActionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER, VisibleConditionForColorItemReferToSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER, VisibleConditionForColorItemReferToTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER, VisibleConditionForColorItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER, VisibleConditionForColorItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER, BasicPlusStateBoardColorsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER, BasicPlusStateBoardColorsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER, BasicPlusStateBoardItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER, BasicPlusStateBoardItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER, BasicPlusProgressBarsStateItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER, BasicPlusProgressBarsStateItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER, BasicPlusProgressBarsBarItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER, BasicPlusProgressBarsBarItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER, BasicPlusItemProgressBarsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER, BasicPlusItemProgressBarsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER),
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_SERIALIZER, BasicPlusItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_TRANSFORMER, BasicPlusItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER, GroupVisibleConditionsSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER, GroupVisibleConditionsTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER, VisibleConditionForDetailViewSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER, VisibleConditionForDetailViewTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER, BasicPlusCameraImageSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER, BasicPlusCameraImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER, BasicPlusCameraOverlayIconsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER, BasicPlusCameraOverlayIconsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER, BasicPlusCameraSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER, BasicPlusCameraTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER, BasicPlusTvVolumeCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER, BasicPlusTvVolumeCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER, BasicPlusTvVolumeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER, BasicPlusTvVolumeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER, ButtonForTvSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER, ButtonForTvTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER, BasicPlusTvChannelSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER, BasicPlusTvChannelTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER, BasicPlusTvDirectionalPadCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER, BasicPlusTvDirectionalPadCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER, BasicPlusTvDirectionalPadSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER, BasicPlusTvDirectionalPadTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER, BasicPlusTvSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER, BasicPlusTvTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER, SliderForLightSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER, SliderForLightTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER, BasicPlusLightColorControlColorSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER, BasicPlusLightColorControlColorTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER, BasicPlusLightColorControlSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER, BasicPlusLightColorControlTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER, BasicPlusLightSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER, BasicPlusLightTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER, BasicPlusItemActionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER, BasicPlusItemActionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER, VisibleConditionForColorItemReferToSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER, VisibleConditionForColorItemReferToTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER, VisibleConditionForColorItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER, VisibleConditionForColorItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER, BasicPlusStateBoardColorsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER, BasicPlusStateBoardColorsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER, BasicPlusStateBoardItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER, BasicPlusStateBoardItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER, BasicPlusProgressBarsStateItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER, BasicPlusProgressBarsStateItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER, BasicPlusProgressBarsBarItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER, BasicPlusProgressBarsBarItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER, BasicPlusItemProgressBarsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER, BasicPlusItemProgressBarsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER),
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
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_SERIALIZER, GroupVisibleConditionsSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER, GroupVisibleConditionsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_DASHBOARD_TRANSFORMER, DashboardTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_STATES_ARRAY_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ACTIONS_ARRAY_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_FOR_PRESENTATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_GROUP_VISIBLE_CONDITIONS_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_SERIALIZER, VisibleConditionForDetailViewSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_DETAIL_VIEW_TRANSFORMER, VisibleConditionForDetailViewTransformer::class);
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
        $container->register(SmartThingsInterface::SERVICE_AUTOMATION_TRANSFORMER, AutomationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_AUTOMATION_LIST_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_ACTION_LIST_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DESCRIPTIONS_IN_AUTOMATION_TRANSFORMER),
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
        $container->register(SmartThingsInterface::SERVICE_PREFERENCE_OPTION_LOCALIZATION_TRANSFORMER, PreferenceOptionLocalizationTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LABEL_TRANSFORMER, CapabilityAttributeLabelTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LOCALIZATION_TRANSFORMER, CapabilityAttributeLocalizationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LABEL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_I18N_TRANSFORMER, CapabilityArgumentI18nTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_LOCALIZATION_TRANSFORMER, CapabilityArgumentLocalizationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_I18N_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CAPABILITY_COMMAND_LOCALIZATION_TRANSFORMER, CapabilityCommandLocalizationTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ARGUMENT_LOCALIZATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_LOCALIZATION_DETAILS_TRANSFORMER, LocalizationDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_PREFERENCE_OPTION_LOCALIZATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_ATTRIBUTE_LOCALIZATION_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_CAPABILITY_COMMAND_LOCALIZATION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_UPDATE_DEVICE_COMPONENT_SERIALIZER, UpdateDeviceComponentSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_INDOOR_MAP_SERIALIZER, IndoorMapSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_UPDATE_DEVICE_REQUEST_SERIALIZER, UpdateDeviceRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_UPDATE_DEVICE_COMPONENT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_INDOOR_MAP_SERIALIZER),
                ]
            );
    }
}
