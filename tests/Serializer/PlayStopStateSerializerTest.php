<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\PlayStopState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayStopStateSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayStopState::class)]
#[CoversClass(PlayStopStateSerializer::class)]
final class PlayStopStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new PlayStopState('test-value', 'test-play', 'test-stop');

        $serializer = new PlayStopStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                PlayStopStateSerializerInterface::KEY_VALUE => 'test-value',
                PlayStopStateSerializerInterface::KEY_PLAY => 'test-play',
                PlayStopStateSerializerInterface::KEY_STOP => 'test-stop',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new PlayStopState('test-value', 'test-play', 'test-stop'))
            ->setAlternatives([$alternativeItemModel])
            ->setValueType('test-value-type');

        $serializer = new PlayStopStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                PlayStopStateSerializerInterface::KEY_VALUE => 'test-value',
                PlayStopStateSerializerInterface::KEY_PLAY => 'test-play',
                PlayStopStateSerializerInterface::KEY_STOP => 'test-stop',
                PlayStopStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                PlayStopStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ],
            $serializer->serialize($model)
        );
    }
}
