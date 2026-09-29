<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StateWithAvailableSize;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StateWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\StateWithAvailableSizeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StateWithAvailableSize::class)]
#[CoversClass(StateWithAvailableSizeSerializer::class)]
final class StateWithAvailableSizeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new StateWithAvailableSize('test-label');

        $serializer = new StateWithAvailableSizeSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StateWithAvailableSizeSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new StateWithAvailableSize('test-label'))
            ->setUnit('test-unit')
            ->setAlternatives([$alternativeItemModel])
            ->setAvailableSizes(['test-available-sizes-1', 'test-available-sizes-2']);

        $serializer = new StateWithAvailableSizeSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StateWithAvailableSizeSerializerInterface::KEY_LABEL => 'test-label',
                StateWithAvailableSizeSerializerInterface::KEY_UNIT => 'test-unit',
                StateWithAvailableSizeSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                StateWithAvailableSizeSerializerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
