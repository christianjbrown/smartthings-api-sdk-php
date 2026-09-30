<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PlayPause;
use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;
use ChristianBrown\SmartThings\Model\PlayPauseStateInterface;
use ChristianBrown\SmartThings\Serializer\PlayPauseCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayPauseSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayPauseStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayPause::class)]
#[CoversClass(PlayPauseSerializer::class)]
final class PlayPauseSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $playPauseCommandSerializer = self::createStub(PlayPauseCommandSerializerInterface::class);
        $playPauseCommandSerializer->method('serialize')->willReturn(['test-serialized-play-pause-command']);
        $playPauseStateSerializer = self::createStub(PlayPauseStateSerializerInterface::class);
        $playPauseStateSerializer->method('serialize')->willReturn(['test-serialized-play-pause-state']);
        $model = new PlayPause(null, null);

        $serializer = new PlayPauseSerializer($playPauseCommandSerializer, $playPauseStateSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $playPauseCommandModel = self::createStub(PlayPauseCommandInterface::class);
        $playPauseCommandSerializer = self::createStub(PlayPauseCommandSerializerInterface::class);
        $playPauseCommandSerializer->method('serialize')->willReturn(['test-serialized-play-pause-command']);
        $playPauseStateModel = self::createStub(PlayPauseStateInterface::class);
        $playPauseStateSerializer = self::createStub(PlayPauseStateSerializerInterface::class);
        $playPauseStateSerializer->method('serialize')->willReturn(['test-serialized-play-pause-state']);
        $model = new PlayPause($playPauseCommandModel, $playPauseStateModel);

        $serializer = new PlayPauseSerializer($playPauseCommandSerializer, $playPauseStateSerializer);

        self::assertSame(
            [
                PlayPauseSerializerInterface::KEY_COMMAND => ['test-serialized-play-pause-command'],
                PlayPauseSerializerInterface::KEY_STATE => ['test-serialized-play-pause-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
