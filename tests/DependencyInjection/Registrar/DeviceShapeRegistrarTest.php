<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceShapeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DeviceShapeRegistrar::class)]
final class DeviceShapeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new DeviceShapeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ID_LESS_HEALTH_STATE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_PROFILE_REFERENCE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_APP_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BLE_D2_DDEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DTH_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_LAN_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ZIGBEE_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ZWAVE_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MATTER_VERSION_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MATTER_ENDPOINT_DEVICE_TYPE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MATTER_ENDPOINT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MATTER_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_HUB_DRIVER_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS_APPS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_HUB2HUB_SUPPORT_MATRIX_CAPABILITIES_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_HUB2HUB_SUPPORT_MATRIX_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_HUB_DATA_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_HUB_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_EDGE_CHILD_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_IR_DEVICE_DETAILS_FUNCTION_CODES_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_IR_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_OCF_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VIPER_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_DEVICES_ITEM_COMPONENTS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_DEVICES_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_GROUP_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_ATTRIBUTE_VALUE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_COMMAND_MAPPING_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_COMMAND_MAPPINGS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_MQTT_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INDOOR_MAP_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_RELATIONSHIP_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_DEVICE_DETAILS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_UPDATE_DEVICE_COMPONENT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_INDOOR_MAP_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_UPDATE_DEVICE_REQUEST_SERIALIZER));
    }
}
