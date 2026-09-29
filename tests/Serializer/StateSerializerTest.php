<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\State;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StateSerializer;
use ChristianBrown\SmartThings\Serializer\StateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(State::class)]
#[CoversClass(StateSerializer::class)]
final class StateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new State('test-label');

        $serializer = new StateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StateSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new State('test-label'))
            ->setUnit('test-unit')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new StateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                StateSerializerInterface::KEY_LABEL => 'test-label',
                StateSerializerInterface::KEY_UNIT => 'test-unit',
                StateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
