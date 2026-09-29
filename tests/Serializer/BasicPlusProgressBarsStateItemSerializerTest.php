<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItem;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsStateItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsStateItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusProgressBarsStateItem::class)]
#[CoversClass(BasicPlusProgressBarsStateItemSerializer::class)]
final class BasicPlusProgressBarsStateItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item']);
        $model = new BasicPlusProgressBarsStateItem('test-label', 'test-capability', 'test-component');

        $serializer = new BasicPlusProgressBarsStateItemSerializer($alternativeItemSerializer, $deviceConfigEntryForDashboardStateFormatInfoItemSerializer);

        self::assertSame(
            [
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_LABEL => 'test-label',
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_COMPONENT => 'test-component',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-dashboard-state-format-info-item']);
        $model = (new BasicPlusProgressBarsStateItem('test-label', 'test-capability', 'test-component'))
            ->setAlternatives([$alternativeItemModel])
            ->setVersion(7)
            ->setFormatInfo([$deviceConfigEntryForDashboardStateFormatInfoItemModel])
            ->setIconUrl('test-icon-url')
            ->setPlacement('test-placement');

        $serializer = new BasicPlusProgressBarsStateItemSerializer($alternativeItemSerializer, $deviceConfigEntryForDashboardStateFormatInfoItemSerializer);

        self::assertSame(
            [
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_LABEL => 'test-label',
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_VERSION => 7,
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_FORMAT_INFO => [['test-serialized-device-config-entry-for-dashboard-state-format-info-item']],
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                BasicPlusProgressBarsStateItemSerializerInterface::KEY_PLACEMENT => 'test-placement',
            ],
            $serializer->serialize($model)
        );
    }
}
