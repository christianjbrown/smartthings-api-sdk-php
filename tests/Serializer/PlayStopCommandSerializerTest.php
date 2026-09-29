<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PlayStopCommand;
use ChristianBrown\SmartThings\Serializer\PlayStopCommandSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayStopCommand::class)]
#[CoversClass(PlayStopCommandSerializer::class)]
final class PlayStopCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PlayStopCommand('test-play', 'test-stop');

        $serializer = new PlayStopCommandSerializer();

        self::assertSame(
            [
                PlayStopCommandSerializerInterface::KEY_PLAY => 'test-play',
                PlayStopCommandSerializerInterface::KEY_STOP => 'test-stop',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PlayStopCommand('test-play', 'test-stop'))
            ->setName('test-name')
            ->setArgumentType('test-argument-type');

        $serializer = new PlayStopCommandSerializer();

        self::assertSame(
            [
                PlayStopCommandSerializerInterface::KEY_NAME => 'test-name',
                PlayStopCommandSerializerInterface::KEY_PLAY => 'test-play',
                PlayStopCommandSerializerInterface::KEY_STOP => 'test-stop',
                PlayStopCommandSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            ],
            $serializer->serialize($model)
        );
    }
}
