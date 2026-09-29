<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationCondition;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumSliderForAutomationCondition::class)]
#[CoversClass(EnumSliderForAutomationConditionSerializer::class)]
final class EnumSliderForAutomationConditionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $enumSliderForAutomationConditionSupportedOperatorsItemModel = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemSerializer = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemSerializer->method('serialize')->willReturn(['test-serialized-enum-slider-for-automation-condition-supported-operators-item']);
        $model = new EnumSliderForAutomationCondition([$alternativeItemModel], 'test-value');

        $serializer = new EnumSliderForAutomationConditionSerializer($alternativeItemSerializer, $enumSliderForAutomationConditionSupportedOperatorsItemSerializer);

        self::assertSame(
            [
                EnumSliderForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                EnumSliderForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $enumSliderForAutomationConditionSupportedOperatorsItemModel = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemSerializer = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemSerializer->method('serialize')->willReturn(['test-serialized-enum-slider-for-automation-condition-supported-operators-item']);
        $model = (new EnumSliderForAutomationCondition([$alternativeItemModel], 'test-value'))
            ->setSupportedOperators([$enumSliderForAutomationConditionSupportedOperatorsItemModel]);

        $serializer = new EnumSliderForAutomationConditionSerializer($alternativeItemSerializer, $enumSliderForAutomationConditionSupportedOperatorsItemSerializer);

        self::assertSame(
            [
                EnumSliderForAutomationConditionSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                EnumSliderForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                EnumSliderForAutomationConditionSerializerInterface::KEY_SUPPORTED_OPERATORS => [['test-serialized-enum-slider-for-automation-condition-supported-operators-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
