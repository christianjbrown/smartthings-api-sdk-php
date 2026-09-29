<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationCondition;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\NumberFieldForAutomationConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumberFieldForAutomationCondition::class)]
#[CoversClass(NumberFieldForAutomationConditionSerializer::class)]
final class NumberFieldForAutomationConditionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new NumberFieldForAutomationCondition('test-value');

        $serializer = new NumberFieldForAutomationConditionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                NumberFieldForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new NumberFieldForAutomationCondition('test-value'))
            ->setValueType('test-value-type')
            ->setUnit('test-unit')
            ->setRange(['test-range-key' => 'test-value'])
            ->setAlternatives([$alternativeItemModel])
            ->setSupportedValues('test-supported-values')
            ->setDescription('test-description');

        $serializer = new NumberFieldForAutomationConditionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                NumberFieldForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                NumberFieldForAutomationConditionSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                NumberFieldForAutomationConditionSerializerInterface::KEY_UNIT => 'test-unit',
                NumberFieldForAutomationConditionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                NumberFieldForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                NumberFieldForAutomationConditionSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                NumberFieldForAutomationConditionSerializerInterface::KEY_DESCRIPTION => 'test-description',
            ],
            $serializer->serialize($model)
        );
    }
}
