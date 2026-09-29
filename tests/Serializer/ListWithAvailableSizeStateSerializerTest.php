<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeStateSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListWithAvailableSizeState::class)]
#[CoversClass(ListWithAvailableSizeStateSerializer::class)]
final class ListWithAvailableSizeStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new ListWithAvailableSizeState('test-value', [$alternativeItemModel]);

        $serializer = new ListWithAvailableSizeStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListWithAvailableSizeStateSerializerInterface::KEY_VALUE => 'test-value',
                ListWithAvailableSizeStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new ListWithAvailableSizeState('test-value', [$alternativeItemModel]))
            ->setValueType('test-value-type');

        $serializer = new ListWithAvailableSizeStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                ListWithAvailableSizeStateSerializerInterface::KEY_VALUE => 'test-value',
                ListWithAvailableSizeStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                ListWithAvailableSizeStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
