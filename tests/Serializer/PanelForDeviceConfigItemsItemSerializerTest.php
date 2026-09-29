<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueForPanelInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueForPanelSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigItemsItemSerializer;
use ChristianBrown\SmartThings\Serializer\PanelForDeviceConfigItemsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PanelForDeviceConfigItemsItem::class)]
#[CoversClass(PanelForDeviceConfigItemsItemSerializer::class)]
final class PanelForDeviceConfigItemsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityValueForPanelModel = self::createStub(CapabilityValueForPanelInterface::class);
        $capabilityValueForPanelSerializer = self::createStub(CapabilityValueForPanelSerializerInterface::class);
        $capabilityValueForPanelSerializer->method('serialize')->willReturn(['test-serialized-capability-value-for-panel']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new PanelForDeviceConfigItemsItem('test-component', 'test-capability', 'test-size');

        $serializer = new PanelForDeviceConfigItemsItemSerializer($capabilityValueForPanelSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_COMPONENT => 'test-component',
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_SIZE => 'test-size',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $capabilityValueForPanelModel = self::createStub(CapabilityValueForPanelInterface::class);
        $capabilityValueForPanelSerializer = self::createStub(CapabilityValueForPanelSerializerInterface::class);
        $capabilityValueForPanelSerializer->method('serialize')->willReturn(['test-serialized-capability-value-for-panel']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new PanelForDeviceConfigItemsItem('test-component', 'test-capability', 'test-size'))
            ->setVersion(7)
            ->setIdx(7)
            ->setValues([$capabilityValueForPanelModel])
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel])
            ->setHideOnUnmatch(true);

        $serializer = new PanelForDeviceConfigItemsItemSerializer($capabilityValueForPanelSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_COMPONENT => 'test-component',
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_VERSION => 7,
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_IDX => 7,
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_SIZE => 'test-size',
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_VALUES => [['test-serialized-capability-value-for-panel']],
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
                PanelForDeviceConfigItemsItemSerializerInterface::KEY_HIDE_ON_UNMATCH => true,
            ],
            $serializer->serialize($model)
        );
    }
}
