<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ActionItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapability;
use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;
use ChristianBrown\SmartThings\Model\StateItemInterface;
use ChristianBrown\SmartThings\Serializer\ActionItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializer;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\PanelItemForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\StateItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DashboardForCapability::class)]
#[CoversClass(DashboardForCapabilitySerializer::class)]
final class DashboardForCapabilitySerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemSerializer = self::createStub(StateItemSerializerInterface::class);
        $stateItemSerializer->method('serialize')->willReturn(['test-serialized-state-item']);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemSerializer = self::createStub(ActionItemSerializerInterface::class);
        $actionItemSerializer->method('serialize')->willReturn(['test-serialized-action-item']);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilitySerializer = self::createStub(PanelItemForCapabilitySerializerInterface::class);
        $panelItemForCapabilitySerializer->method('serialize')->willReturn(['test-serialized-panel-item-for-capability']);
        $model = new DashboardForCapability();

        $serializer = new DashboardForCapabilitySerializer($stateItemSerializer, $actionItemSerializer, $panelItemForCapabilitySerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $stateItemModel = self::createStub(StateItemInterface::class);
        $stateItemSerializer = self::createStub(StateItemSerializerInterface::class);
        $stateItemSerializer->method('serialize')->willReturn(['test-serialized-state-item']);
        $actionItemModel = self::createStub(ActionItemInterface::class);
        $actionItemSerializer = self::createStub(ActionItemSerializerInterface::class);
        $actionItemSerializer->method('serialize')->willReturn(['test-serialized-action-item']);
        $panelItemForCapabilityModel = self::createStub(PanelItemForCapabilityInterface::class);
        $panelItemForCapabilitySerializer = self::createStub(PanelItemForCapabilitySerializerInterface::class);
        $panelItemForCapabilitySerializer->method('serialize')->willReturn(['test-serialized-panel-item-for-capability']);
        $model = (new DashboardForCapability())
            ->setStates([$stateItemModel])
            ->setActions([$actionItemModel])
            ->setPanelItems([$panelItemForCapabilityModel]);

        $serializer = new DashboardForCapabilitySerializer($stateItemSerializer, $actionItemSerializer, $panelItemForCapabilitySerializer);

        self::assertSame(
            [
                DashboardForCapabilitySerializerInterface::KEY_STATES => [['test-serialized-state-item']],
                DashboardForCapabilitySerializerInterface::KEY_ACTIONS => [['test-serialized-action-item']],
                DashboardForCapabilitySerializerInterface::KEY_PANEL_ITEMS => [['test-serialized-panel-item-for-capability']],
            ],
            $serializer->serialize($model)
        );
    }
}
