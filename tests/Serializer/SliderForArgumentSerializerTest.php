<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForArgument;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderForArgumentSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForArgumentSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderForArgument::class)]
#[CoversClass(SliderForArgumentSerializer::class)]
final class SliderForArgumentSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new SliderForArgument(['test-range-key' => 'test-value'], 'test-name');

        $serializer = new SliderForArgumentSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderForArgumentSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForArgumentSerializerInterface::KEY_NAME => 'test-name',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new SliderForArgument(['test-range-key' => 'test-value'], 'test-name'))
            ->setStep(1.5)
            ->setUnit('test-unit')
            ->setSupportedValues('test-supported-values')
            ->setArgumentType('test-argument-type')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new SliderForArgumentSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                SliderForArgumentSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForArgumentSerializerInterface::KEY_STEP => 1.5,
                SliderForArgumentSerializerInterface::KEY_UNIT => 'test-unit',
                SliderForArgumentSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                SliderForArgumentSerializerInterface::KEY_NAME => 'test-name',
                SliderForArgumentSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                SliderForArgumentSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
