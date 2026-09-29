<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationCondition;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\ListForAutomationConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListForAutomationCondition::class)]
#[CoversClass(ListForAutomationConditionSerializer::class)]
final class ListForAutomationConditionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new ListForAutomationCondition([$alternativeItemModel], 'test-value');

        $serializer = new ListForAutomationConditionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                ListForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new ListForAutomationCondition([$alternativeItemModel], 'test-value'))
            ->setSupportedValues('test-supported-values')
            ->setValueType('test-value-type')
            ->setMultiSelectable(true);

        $serializer = new ListForAutomationConditionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                ListForAutomationConditionSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                ListForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                ListForAutomationConditionSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                ListForAutomationConditionSerializerInterface::KEY_MULTI_SELECTABLE => true,
            ],
            $serializer->serialize($model)
        );
    }
}
