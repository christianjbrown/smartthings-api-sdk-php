<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeStateSerializer;
use ChristianBrown\SmartThings\Serializer\StepperWithAvailableSizeStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperWithAvailableSizeState::class)]
#[CoversClass(StepperWithAvailableSizeStateSerializer::class)]
final class StepperWithAvailableSizeStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new StepperWithAvailableSizeState('test-value');

        $serializer = new StepperWithAvailableSizeStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StepperWithAvailableSizeStateSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new StepperWithAvailableSizeState('test-value'))
            ->setUnit('test-unit')
            ->setValueType('test-value-type')
            ->setLabel('test-label')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new StepperWithAvailableSizeStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StepperWithAvailableSizeStateSerializerInterface::KEY_VALUE => 'test-value',
                StepperWithAvailableSizeStateSerializerInterface::KEY_UNIT => 'test-unit',
                StepperWithAvailableSizeStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                StepperWithAvailableSizeStateSerializerInterface::KEY_LABEL => 'test-label',
                StepperWithAvailableSizeStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
