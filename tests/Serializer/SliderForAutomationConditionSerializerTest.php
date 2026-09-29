<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationCondition;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForAutomationConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderForAutomationCondition::class)]
#[CoversClass(SliderForAutomationConditionSerializer::class)]
final class SliderForAutomationConditionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new SliderForAutomationCondition(['test-range-key' => 'test-value'], 'test-value');

        $serializer = new SliderForAutomationConditionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderForAutomationConditionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new SliderForAutomationCondition(['test-range-key' => 'test-value'], 'test-value'))
            ->setStep(1.5)
            ->setUnit('test-unit')
            ->setSupportedValues('test-supported-values')
            ->setAlternatives([$alternativeItemModel])
            ->setValueType('test-value-type');

        $serializer = new SliderForAutomationConditionSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderForAutomationConditionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForAutomationConditionSerializerInterface::KEY_STEP => 1.5,
                SliderForAutomationConditionSerializerInterface::KEY_UNIT => 'test-unit',
                SliderForAutomationConditionSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                SliderForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                SliderForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                SliderForAutomationConditionSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ],
            $serializer->serialize($model)
        );
    }
}
