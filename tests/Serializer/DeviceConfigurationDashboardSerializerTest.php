<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboard;
use ChristianBrown\SmartThings\Model\GroupVisibleConditionsInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDashboardSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\GroupVisibleConditionsSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationDashboard::class)]
#[CoversClass(DeviceConfigurationDashboardSerializer::class)]
final class DeviceConfigurationDashboardSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateSerializer = self::createStub(DeviceConfigEntryForDashboardStateSerializerInterface::class);
        $deviceConfigEntryForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state']);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionSerializer = self::createStub(DeviceConfigEntryForDashboardActionSerializerInterface::class);
        $deviceConfigEntryForDashboardActionSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-action']);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemSerializer = self::createStub(BasicPlusItemSerializerInterface::class);
        $basicPlusItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-item']);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsSerializer = self::createStub(GroupVisibleConditionsSerializerInterface::class);
        $groupVisibleConditionsSerializer->method('serialize')->willReturn(['test-serialized-group-visible-conditions']);
        $model = new DeviceConfigurationDashboard();

        $serializer = new DeviceConfigurationDashboardSerializer($deviceConfigEntryForDashboardStateSerializer, $deviceConfigEntryForDashboardActionSerializer, $basicPlusItemSerializer, $groupVisibleConditionsSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigEntryForDashboardStateModel = self::createStub(DeviceConfigEntryForDashboardStateInterface::class);
        $deviceConfigEntryForDashboardStateSerializer = self::createStub(DeviceConfigEntryForDashboardStateSerializerInterface::class);
        $deviceConfigEntryForDashboardStateSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state']);
        $deviceConfigEntryForDashboardActionModel = self::createStub(DeviceConfigEntryForDashboardActionInterface::class);
        $deviceConfigEntryForDashboardActionSerializer = self::createStub(DeviceConfigEntryForDashboardActionSerializerInterface::class);
        $deviceConfigEntryForDashboardActionSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-action']);
        $basicPlusItemModel = self::createStub(BasicPlusItemInterface::class);
        $basicPlusItemSerializer = self::createStub(BasicPlusItemSerializerInterface::class);
        $basicPlusItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-item']);
        $groupVisibleConditionsModel = self::createStub(GroupVisibleConditionsInterface::class);
        $groupVisibleConditionsSerializer = self::createStub(GroupVisibleConditionsSerializerInterface::class);
        $groupVisibleConditionsSerializer->method('serialize')->willReturn(['test-serialized-group-visible-conditions']);
        $model = (new DeviceConfigurationDashboard())
            ->setStates([$deviceConfigEntryForDashboardStateModel])
            ->setActions([$deviceConfigEntryForDashboardActionModel])
            ->setBasicPlus([$basicPlusItemModel])
            ->setGroupVisibleConditions($groupVisibleConditionsModel);

        $serializer = new DeviceConfigurationDashboardSerializer($deviceConfigEntryForDashboardStateSerializer, $deviceConfigEntryForDashboardActionSerializer, $basicPlusItemSerializer, $groupVisibleConditionsSerializer);

        self::assertSame(
            [
                DeviceConfigurationDashboardSerializerInterface::KEY_STATES => [['test-serialized-device-config-entry-for-dashboard-state']],
                DeviceConfigurationDashboardSerializerInterface::KEY_ACTIONS => [['test-serialized-device-config-entry-for-dashboard-action']],
                DeviceConfigurationDashboardSerializerInterface::KEY_BASIC_PLUS => [['test-serialized-basic-plus-item']],
                DeviceConfigurationDashboardSerializerInterface::KEY_GROUP_VISIBLE_CONDITIONS => ['test-serialized-group-visible-conditions'],
            ],
            $serializer->serialize($model)
        );
    }
}
