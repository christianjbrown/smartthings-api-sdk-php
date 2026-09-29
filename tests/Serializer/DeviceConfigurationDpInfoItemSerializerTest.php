<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationDpInfoItem::class)]
#[CoversClass(DeviceConfigurationDpInfoItemSerializer::class)]
final class DeviceConfigurationDpInfoItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigurationDpInfoItemArgumentsItemModel = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemSerializer = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-info-item-arguments-item']);
        $model = new DeviceConfigurationDpInfoItem('test-os', 'test-dp-uri');

        $serializer = new DeviceConfigurationDpInfoItemSerializer($deviceConfigurationDpInfoItemArgumentsItemSerializer);

        self::assertSame(
            [
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_OS => 'test-os',
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_DP_URI => 'test-dp-uri',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigurationDpInfoItemArgumentsItemModel = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemSerializer = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-info-item-arguments-item']);
        $model = (new DeviceConfigurationDpInfoItem('test-os', 'test-dp-uri'))
            ->setServerDpUri('test-server-dp-uri')
            ->setOperatingMode('test-operating-mode')
            ->setArguments([$deviceConfigurationDpInfoItemArgumentsItemModel]);

        $serializer = new DeviceConfigurationDpInfoItemSerializer($deviceConfigurationDpInfoItemArgumentsItemSerializer);

        self::assertSame(
            [
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_OS => 'test-os',
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_DP_URI => 'test-dp-uri',
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_SERVER_DP_URI => 'test-server-dp-uri',
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_OPERATING_MODE => 'test-operating-mode',
                DeviceConfigurationDpInfoItemSerializerInterface::KEY_ARGUMENTS => [['test-serialized-device-configuration-dp-info-item-arguments-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
