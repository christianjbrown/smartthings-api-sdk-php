<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderType;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderTypeSerializer;
use ChristianBrown\SmartThings\Serializer\SliderTypeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderType::class)]
#[CoversClass(SliderTypeSerializer::class)]
final class SliderTypeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new SliderType(['test-range-key' => 'test-value']);

        $serializer = new SliderTypeSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderTypeSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new SliderType(['test-range-key' => 'test-value']))
            ->setStep(1.5)
            ->setUnit('test-unit')
            ->setSupportedValues('test-supported-values')
            ->setAlternatives([$alternativeItemModel])
            ->setCommand('test-command')
            ->setArgumentType('test-argument-type')
            ->setValue('test-value')
            ->setValueType('test-value-type');

        $serializer = new SliderTypeSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderTypeSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderTypeSerializerInterface::KEY_STEP => 1.5,
                SliderTypeSerializerInterface::KEY_UNIT => 'test-unit',
                SliderTypeSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                SliderTypeSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                SliderTypeSerializerInterface::KEY_COMMAND => 'test-command',
                SliderTypeSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                SliderTypeSerializerInterface::KEY_VALUE => 'test-value',
                SliderTypeSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ],
            $serializer->serialize($model)
        );
    }
}
