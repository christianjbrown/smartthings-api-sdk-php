<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemBadgeItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemBadgeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationIconsItemBadgeItem::class)]
#[CoversClass(DeviceConfigurationIconsItemBadgeItemSerializer::class)]
final class DeviceConfigurationIconsItemBadgeItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new DeviceConfigurationIconsItemBadgeItem('test-icon-url');

        $serializer = new DeviceConfigurationIconsItemBadgeItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                DeviceConfigurationIconsItemBadgeItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new DeviceConfigurationIconsItemBadgeItem('test-icon-url'))
            ->setVisibleConditions([$visibleConditionModel]);

        $serializer = new DeviceConfigurationIconsItemBadgeItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                DeviceConfigurationIconsItemBadgeItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                DeviceConfigurationIconsItemBadgeItemSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
            ],
            $serializer->serialize($model)
        );
    }
}
