<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PanelForDeviceConfig;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigItemsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigSerializer;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PanelForDeviceConfig::class)]
#[CoversClass(PanelForDeviceConfigSerializer::class)]
final class PanelForDeviceConfigSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $panelForDeviceConfigItemsItemModel = self::createStub(PanelForDeviceConfigItemsItemInterface::class);
        $panelForDeviceConfigItemsItemSerializer = self::createStub(PanelForDeviceConfigItemsItemSerializerInterface::class);
        $panelForDeviceConfigItemsItemSerializer->method('serialize')->willReturn(['test-serialized-panel-for-device-config-items-item']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new PanelForDeviceConfig([$panelForDeviceConfigItemsItemModel]);

        $serializer = new PanelForDeviceConfigSerializer($panelForDeviceConfigItemsItemSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                PanelForDeviceConfigSerializerInterface::KEY_ITEMS => [['test-serialized-panel-for-device-config-items-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $panelForDeviceConfigItemsItemModel = self::createStub(PanelForDeviceConfigItemsItemInterface::class);
        $panelForDeviceConfigItemsItemSerializer = self::createStub(PanelForDeviceConfigItemsItemSerializerInterface::class);
        $panelForDeviceConfigItemsItemSerializer->method('serialize')->willReturn(['test-serialized-panel-for-device-config-items-item']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new PanelForDeviceConfig([$panelForDeviceConfigItemsItemModel]))
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel])
            ->setHideDashboardActions(true);

        $serializer = new PanelForDeviceConfigSerializer($panelForDeviceConfigItemsItemSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                PanelForDeviceConfigSerializerInterface::KEY_ITEMS => [['test-serialized-panel-for-device-config-items-item']],
                PanelForDeviceConfigSerializerInterface::KEY_OPERATOR => 'test-operator',
                PanelForDeviceConfigSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
                PanelForDeviceConfigSerializerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
            ],
            $serializer->serialize($model)
        );
    }
}
