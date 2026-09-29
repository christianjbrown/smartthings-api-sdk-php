<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntry;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityValueSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceConditionConfigEntrySerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceConditionConfigEntrySerializerInterface;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedDeviceConditionConfigEntry::class)]
#[CoversClass(ExcludedDeviceConditionConfigEntrySerializer::class)]
final class ExcludedDeviceConditionConfigEntrySerializerTest extends TestCase
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdSerializer = self::createStub(ExcludedConditionItemIdSerializerInterface::class);
        $excludedConditionItemIdSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id']);
        $model = new ExcludedDeviceConditionConfigEntry('test-component', 'test-capability');

        $serializer = new ExcludedDeviceConditionConfigEntrySerializer($capabilityValueSerializer, $patchItemSerializer, $visibleConditionSerializer, $excludedConditionItemIdSerializer);

        self::assertSame(
            [
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_COMPONENT => 'test-component',
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_CAPABILITY => 'test-capability',
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
        $excludedConditionItemIdModel = self::createStub(ExcludedConditionItemIdInterface::class);
        $excludedConditionItemIdSerializer = self::createStub(ExcludedConditionItemIdSerializerInterface::class);
        $excludedConditionItemIdSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id']);
        $model = (new ExcludedDeviceConditionConfigEntry('test-component', 'test-capability'))
            ->setVersion(7)
            ->setValues([$capabilityValueModel])
            ->setPatch([$patchItemModel])
            ->setVisibleCondition($visibleConditionModel)
            ->setExclusion([$excludedConditionItemIdModel]);

        $serializer = new ExcludedDeviceConditionConfigEntrySerializer($capabilityValueSerializer, $patchItemSerializer, $visibleConditionSerializer, $excludedConditionItemIdSerializer);

        self::assertSame(
            [
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_COMPONENT => 'test-component',
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_CAPABILITY => 'test-capability',
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_VERSION => 7,
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_VALUES => [['test-serialized-capability-value']],
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_PATCH => [['test-serialized-patch-item']],
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition'],
                ExcludedDeviceConditionConfigEntrySerializerInterface::KEY_EXCLUSION => [['test-serialized-excluded-condition-item-id']],
            ],
            $serializer->serialize($model)
        );
    }
}
