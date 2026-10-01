<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\IndoorMapSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceComponentSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\AppDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformer;
use ChristianBrown\SmartThings\Transformer\BleD2DDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformer;
use ChristianBrown\SmartThings\Transformer\CommandMappingTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRelationshipTransformer;
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
use ChristianBrown\SmartThings\Transformer\IdLessHealthStateTransformer;
use ChristianBrown\SmartThings\Transformer\IndoorMapTransformer;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsFunctionCodesTransformer;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LanDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointDeviceTypeTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointTransformer;
use ChristianBrown\SmartThings\Transformer\MatterVersionTransformer;
use ChristianBrown\SmartThings\Transformer\MqttDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\OcfDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ViperDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\VirtualDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ZwaveDeviceDetailsTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DeviceShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
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
