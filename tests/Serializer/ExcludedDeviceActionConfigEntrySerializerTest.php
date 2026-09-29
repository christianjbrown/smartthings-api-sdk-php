<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntry;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceActionConfigEntrySerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceActionConfigEntrySerializerInterface;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedDeviceActionConfigEntry::class)]
#[CoversClass(ExcludedDeviceActionConfigEntrySerializer::class)]
final class ExcludedDeviceActionConfigEntrySerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $capabilityValueModel = self::createStub(CapabilityValueInterface::class);
        $capabilityValueSerializer = self::createStub(CapabilityValueSerializerInterface::class);
        $capabilityValueSerializer->method('serialize')->willReturn(['test-serialized-capability-value']);
        $patchItemModel = self::createStub(PatchItemInterface::class);
        $patchItemSerializer = self::createStub(PatchItemSerializerInterface::class);
        $patchItemSerializer->method('serialize')->willReturn(['test-serialized-patch-item']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdSerializer = self::createStub(ExcludedActionItemIdSerializerInterface::class);
        $excludedActionItemIdSerializer->method('serialize')->willReturn(['test-serialized-excluded-action-item-id']);
        $model = new ExcludedDeviceActionConfigEntry('test-component', 'test-capability');

        $serializer = new ExcludedDeviceActionConfigEntrySerializer($capabilityValueSerializer, $patchItemSerializer, $visibleConditionSerializer, $excludedActionItemIdSerializer);

        self::assertSame(
            [
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_COMPONENT => 'test-component',
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_CAPABILITY => 'test-capability',
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
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $excludedActionItemIdModel = self::createStub(ExcludedActionItemIdInterface::class);
        $excludedActionItemIdSerializer = self::createStub(ExcludedActionItemIdSerializerInterface::class);
        $excludedActionItemIdSerializer->method('serialize')->willReturn(['test-serialized-excluded-action-item-id']);
        $model = (new ExcludedDeviceActionConfigEntry('test-component', 'test-capability'))
            ->setVersion(7)
            ->setValues([$capabilityValueModel])
            ->setPatch([$patchItemModel])
            ->setVisibleCondition($visibleConditionModel)
            ->setExclusion([$excludedActionItemIdModel]);

        $serializer = new ExcludedDeviceActionConfigEntrySerializer($capabilityValueSerializer, $patchItemSerializer, $visibleConditionSerializer, $excludedActionItemIdSerializer);

        self::assertSame(
            [
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_COMPONENT => 'test-component',
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_CAPABILITY => 'test-capability',
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_VERSION => 7,
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_VALUES => [['test-serialized-capability-value']],
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_PATCH => [['test-serialized-patch-item']],
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition'],
                ExcludedDeviceActionConfigEntrySerializerInterface::KEY_EXCLUSION => [['test-serialized-excluded-action-item-id']],
            ],
            $serializer->serialize($model)
        );
    }
}
