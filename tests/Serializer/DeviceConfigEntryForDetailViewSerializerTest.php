<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailView;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailViewInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDetailViewSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDetailViewSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigEntryForDetailView::class)]
#[CoversClass(DeviceConfigEntryForDetailViewSerializer::class)]
final class DeviceConfigEntryForDetailViewSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueSerializer = self::createStub(CapabilityValueSerializerInterface::class);
        $capabilityValueSerializer->method('serialize')->willReturn(['test-serialized-capability-value']);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemSerializer = self::createStub(PatchItemSerializerInterface::class);
        $patchItemSerializer->method('serialize')->willReturn(['test-serialized-patch-item']);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewSerializer = self::createStub(VisibleConditionForDetailViewSerializerInterface::class);
        $visibleConditionForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-detail-view']);
        $model = new DeviceConfigEntryForDetailView('test-component', 'test-capability');

        $serializer = new DeviceConfigEntryForDetailViewSerializer($capabilityValueSerializer, $patchItemSerializer, $visibleConditionForDetailViewSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_COMPONENT => 'test-component',
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueSerializer = self::createStub(CapabilityValueSerializerInterface::class);
        $capabilityValueSerializer->method('serialize')->willReturn(['test-serialized-capability-value']);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemSerializer = self::createStub(PatchItemSerializerInterface::class);
        $patchItemSerializer->method('serialize')->willReturn(['test-serialized-patch-item']);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewSerializer = self::createStub(VisibleConditionForDetailViewSerializerInterface::class);
        $visibleConditionForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-detail-view']);
        $model = (new DeviceConfigEntryForDetailView('test-component', 'test-capability'))
            ->setVersion(7)
            ->setValues([$capabilityValueModel])
            ->setPatch([$patchItemModel])
            ->setVisibleCondition($visibleConditionForDetailViewModel);

        $serializer = new DeviceConfigEntryForDetailViewSerializer($capabilityValueSerializer, $patchItemSerializer, $visibleConditionForDetailViewSerializer);

        self::assertSame(
            [
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_COMPONENT => 'test-component',
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_CAPABILITY => 'test-capability',
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_VERSION => 7,
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_VALUES => [['test-serialized-capability-value']],
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_PATCH => [['test-serialized-patch-item']],
                DeviceConfigEntryForDetailViewSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition-for-detail-view'],
            ],
            $serializer->serialize($model)
        );
    }
}
