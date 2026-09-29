<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItem;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItem::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateFormatInfoItemSerializer::class)]
final class DeviceConfigEntryForDashboardStateFormatInfoItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item-remaining-time']);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item-time']);
        $model = new DeviceConfigEntryForDashboardStateFormatInfoItem('test-key', 'test-type');

        $serializer = new DeviceConfigEntryForDashboardStateFormatInfoItemSerializer($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer, $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::KEY_KEY => 'test-key',
                DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::KEY_TYPE => 'test-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item-remaining-time']);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item-time']);
        $model = (new DeviceConfigEntryForDashboardStateFormatInfoItem('test-key', 'test-type'))
            ->setRemainingTime($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeModel)
            ->setTime($deviceConfigEntryForDashboardStateFormatInfoItemTimeModel);

        $serializer = new DeviceConfigEntryForDashboardStateFormatInfoItemSerializer($deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer, $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::KEY_KEY => 'test-key',
                DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::KEY_TYPE => 'test-type',
                DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::KEY_REMAINING_TIME => ['test-serialized-device-config-entry-for-dashboard-state-format-info-item-remaining-time'],
                DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::KEY_TIME => ['test-serialized-device-config-entry-for-dashboard-state-format-info-item-time'],
            ],
            $serializer->serialize($model)
        );
    }
}
