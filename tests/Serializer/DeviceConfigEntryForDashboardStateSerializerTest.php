<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardState;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardStateInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForDashboardStateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDashboardState::class)]
#[CoversClass(DeviceConfigEntryForDashboardStateSerializer::class)]
final class DeviceConfigEntryForDashboardStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateSerializer = self::createStub(CapabilityValueForDashboardStateSerializerInterface::class);
        $capabilityValueForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-capability-value-for-dashboard-state']);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item']);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateSerializer = self::createStub(VisibleConditionForDashboardStateSerializerInterface::class);
        $visibleConditionForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-dashboard-state']);
        $model = new DeviceConfigEntryForDashboardState('test-component', 'test-capability');

        $serializer = new DeviceConfigEntryForDashboardStateSerializer($capabilityValueForDashboardStateSerializer, $deviceConfigEntryForDashboardStateFormatInfoItemSerializer, $visibleConditionForDashboardStateSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_COMPONENT => 'test-component',
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $capabilityValueForDashboardStateModel = self::createStub(CapabilityValueForDashboardStateInterface::class);
        $capabilityValueForDashboardStateSerializer = self::createStub(CapabilityValueForDashboardStateSerializerInterface::class);
        $capabilityValueForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-capability-value-for-dashboard-state']);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item']);
        $visibleConditionForDashboardStateModel = self::createStub(VisibleConditionForDashboardStateInterface::class);
        $visibleConditionForDashboardStateSerializer = self::createStub(VisibleConditionForDashboardStateSerializerInterface::class);
        $visibleConditionForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-dashboard-state']);
        $model = (new DeviceConfigEntryForDashboardState('test-component', 'test-capability'))
            ->setVersion(7)
            ->setIdx(7)
            ->setGroup('test-group')
            ->setValues([$capabilityValueForDashboardStateModel])
            ->setComposite(true)
            ->setFormatInfo([$deviceConfigEntryForDashboardStateFormatInfoItemModel])
            ->setVisibleCondition($visibleConditionForDashboardStateModel);

        $serializer = new DeviceConfigEntryForDashboardStateSerializer($capabilityValueForDashboardStateSerializer, $deviceConfigEntryForDashboardStateFormatInfoItemSerializer, $visibleConditionForDashboardStateSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_COMPONENT => 'test-component',
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_CAPABILITY => 'test-capability',
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_VERSION => 7,
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_IDX => 7,
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_GROUP => 'test-group',
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_VALUES => [['test-serialized-capability-value-for-dashboard-state']],
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_COMPOSITE => true,
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_FORMAT_INFO => [['test-serialized-device-config-entry-for-dashboard-state-format-info-item']],
                DeviceConfigEntryForDashboardStateSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition-for-dashboard-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
