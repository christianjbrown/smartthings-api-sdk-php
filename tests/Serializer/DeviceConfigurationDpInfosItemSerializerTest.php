<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItem;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfosItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfosItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationDpInfosItem::class)]
#[CoversClass(DeviceConfigurationDpInfosItemSerializer::class)]
final class DeviceConfigurationDpInfosItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemSerializer = self::createStub(DeviceConfigurationDpInfoItemSerializerInterface::class);
        $deviceConfigurationDpInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-info-item']);
        $model = new DeviceConfigurationDpInfosItem([$deviceConfigurationDpInfoItemModel]);

        $serializer = new DeviceConfigurationDpInfosItemSerializer($deviceConfigurationDpInfoItemSerializer);

        self::assertSame(
            [
                DeviceConfigurationDpInfosItemSerializerInterface::KEY_DP_INFO => [['test-serialized-device-configuration-dp-info-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemSerializer = self::createStub(DeviceConfigurationDpInfoItemSerializerInterface::class);
        $deviceConfigurationDpInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-info-item']);
        $model = (new DeviceConfigurationDpInfosItem([$deviceConfigurationDpInfoItemModel]))
            ->setStPluginApiVersion('test-st-plugin-api-version');

        $serializer = new DeviceConfigurationDpInfosItemSerializer($deviceConfigurationDpInfoItemSerializer);

        self::assertSame(
            [
                DeviceConfigurationDpInfosItemSerializerInterface::KEY_ST_PLUGIN_API_VERSION => 'test-st-plugin-api-version',
                DeviceConfigurationDpInfosItemSerializerInterface::KEY_DP_INFO => [['test-serialized-device-configuration-dp-info-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
