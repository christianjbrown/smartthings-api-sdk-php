<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemBadgeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemProductKeysItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationIconsItem::class)]
#[CoversClass(DeviceConfigurationIconsItemSerializer::class)]
final class DeviceConfigurationIconsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemSerializer = self::createStub(DeviceConfigurationIconsItemBadgeItemSerializerInterface::class);
        $deviceConfigurationIconsItemBadgeItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item-badge-item']);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemSerializer = self::createStub(DeviceConfigurationIconsItemProductKeysItemSerializerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item-product-keys-item']);
        $model = new DeviceConfigurationIconsItem();

        $serializer = new DeviceConfigurationIconsItemSerializer($visibleConditionSerializer, $deviceConfigurationIconsItemBadgeItemSerializer, $deviceConfigurationIconsItemProductKeysItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $deviceConfigurationIconsItemBadgeItemModel = self::createStub(DeviceConfigurationIconsItemBadgeItemInterface::class);
        $deviceConfigurationIconsItemBadgeItemSerializer = self::createStub(DeviceConfigurationIconsItemBadgeItemSerializerInterface::class);
        $deviceConfigurationIconsItemBadgeItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item-badge-item']);
        $deviceConfigurationIconsItemProductKeysItemModel = self::createStub(DeviceConfigurationIconsItemProductKeysItemInterface::class);
        $deviceConfigurationIconsItemProductKeysItemSerializer = self::createStub(DeviceConfigurationIconsItemProductKeysItemSerializerInterface::class);
        $deviceConfigurationIconsItemProductKeysItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item-product-keys-item']);
        $model = (new DeviceConfigurationIconsItem())
            ->setGroup('test-group')
            ->setIconUrl('test-icon-url')
            ->setRunningConditions([$visibleConditionModel])
            ->setBadge([$deviceConfigurationIconsItemBadgeItemModel])
            ->setProductKeys([$deviceConfigurationIconsItemProductKeysItemModel]);

        $serializer = new DeviceConfigurationIconsItemSerializer($visibleConditionSerializer, $deviceConfigurationIconsItemBadgeItemSerializer, $deviceConfigurationIconsItemProductKeysItemSerializer);

        self::assertSame(
            [
                DeviceConfigurationIconsItemSerializerInterface::KEY_GROUP => 'test-group',
                DeviceConfigurationIconsItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                DeviceConfigurationIconsItemSerializerInterface::KEY_RUNNING_CONDITIONS => [['test-serialized-visible-condition']],
                DeviceConfigurationIconsItemSerializerInterface::KEY_BADGE => [['test-serialized-device-configuration-icons-item-badge-item']],
                DeviceConfigurationIconsItemSerializerInterface::KEY_PRODUCT_KEYS => [['test-serialized-device-configuration-icons-item-product-keys-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
