<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationCondition;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\DynamicListForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DynamicListForAutomationCondition::class)]
#[CoversClass(DynamicListForAutomationConditionSerializer::class)]
final class DynamicListForAutomationConditionSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $supportedValuesForDynamicListSerializer = self::createStub(SupportedValuesForDynamicListSerializerInterface::class);
        $supportedValuesForDynamicListSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list']);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new DynamicListForAutomationCondition('test-value', null);

        $serializer = new DynamicListForAutomationConditionSerializer($supportedValuesForDynamicListSerializer, $alternativeItemSerializer);

        self::assertSame(
            [
                DynamicListForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListSerializer = self::createStub(SupportedValuesForDynamicListSerializerInterface::class);
        $supportedValuesForDynamicListSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list']);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new DynamicListForAutomationCondition('test-value', $supportedValuesForDynamicListModel);

        $serializer = new DynamicListForAutomationConditionSerializer($supportedValuesForDynamicListSerializer, $alternativeItemSerializer);

        self::assertSame(
            [
                DynamicListForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                DynamicListForAutomationConditionSerializerInterface::KEY_SUPPORTED_VALUES => ['test-serialized-supported-values-for-dynamic-list'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListSerializer = self::createStub(SupportedValuesForDynamicListSerializerInterface::class);
        $supportedValuesForDynamicListSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list']);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new DynamicListForAutomationCondition('test-value', $supportedValuesForDynamicListModel))
            ->setValueType('test-value-type')
            ->setAlternatives([$alternativeItemModel])
            ->setMultiSelectable(true);

        $serializer = new DynamicListForAutomationConditionSerializer($supportedValuesForDynamicListSerializer, $alternativeItemSerializer);

        self::assertSame(
            [
                DynamicListForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                DynamicListForAutomationConditionSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                DynamicListForAutomationConditionSerializerInterface::KEY_SUPPORTED_VALUES => ['test-serialized-supported-values-for-dynamic-list'],
                DynamicListForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                DynamicListForAutomationConditionSerializerInterface::KEY_MULTI_SELECTABLE => true,
            ],
            $serializer->serialize($model)
        );
    }
}
