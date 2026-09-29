<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PlayPauseCommand;
use ChristianBrown\SmartThings\Serializer\PlayPauseCommandSerializer;
use ChristianBrown\SmartThings\Serializer\PlayPauseCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayPauseCommand::class)]
#[CoversClass(PlayPauseCommandSerializer::class)]
final class PlayPauseCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PlayPauseCommand('test-play', 'test-pause');

        $serializer = new PlayPauseCommandSerializer();

        self::assertSame(
            [
                PlayPauseCommandSerializerInterface::KEY_PLAY => 'test-play',
                PlayPauseCommandSerializerInterface::KEY_PAUSE => 'test-pause',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PlayPauseCommand('test-play', 'test-pause'))
            ->setName('test-name')
            ->setArgumentType('test-argument-type');

        $serializer = new PlayPauseCommandSerializer();

        self::assertSame(
            [
                PlayPauseCommandSerializerInterface::KEY_NAME => 'test-name',
                PlayPauseCommandSerializerInterface::KEY_PLAY => 'test-play',
                PlayPauseCommandSerializerInterface::KEY_PAUSE => 'test-pause',
                PlayPauseCommandSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
