<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\PlayPauseState;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayPauseStateSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayPauseState::class)]
#[CoversClass(PlayPauseStateSerializer::class)]
final class PlayPauseStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = new PlayPauseState('test-value', 'test-play', 'test-pause');

        $serializer = new PlayPauseStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                PlayPauseStateSerializerInterface::KEY_VALUE => 'test-value',
                PlayPauseStateSerializerInterface::KEY_PLAY => 'test-play',
                PlayPauseStateSerializerInterface::KEY_PAUSE => 'test-pause',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $model = (new PlayPauseState('test-value', 'test-play', 'test-pause'))
            ->setValueType('test-value-type')
            ->setAlternatives([$alternativeItemModel]);

        $serializer = new PlayPauseStateSerializer($alternativeItemSerializer);

        self::assertSame(
            [
                PlayPauseStateSerializerInterface::KEY_VALUE => 'test-value',
                PlayPauseStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                PlayPauseStateSerializerInterface::KEY_PLAY => 'test-play',
                PlayPauseStateSerializerInterface::KEY_PAUSE => 'test-pause',
                PlayPauseStateSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
