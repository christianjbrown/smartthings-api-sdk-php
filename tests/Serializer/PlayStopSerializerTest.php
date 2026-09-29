<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PlayStop;
use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;
use ChristianBrown\SmartThings\Model\PlayStopStateInterface;
use ChristianBrown\SmartThings\Serializer\PlayStopCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayStopSerializer;
use ChristianBrown\SmartThings\Serializer\PlayStopSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayStopStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayStop::class)]
#[CoversClass(PlayStopSerializer::class)]
final class PlayStopSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $playStopCommandModel = self::createStub(PlayStopCommandInterface::class);
        $playStopCommandSerializer = self::createStub(PlayStopCommandSerializerInterface::class);
        $playStopCommandSerializer->method('serialize')->willReturn(['test-serialized-play-stop-command']);
        $playStopStateModel = self::createStub(PlayStopStateInterface::class);
        $playStopStateSerializer = self::createStub(PlayStopStateSerializerInterface::class);
        $playStopStateSerializer->method('serialize')->willReturn(['test-serialized-play-stop-state']);
        $model = new PlayStop($playStopCommandModel, $playStopStateModel);

        $serializer = new PlayStopSerializer($playStopCommandSerializer, $playStopStateSerializer);

        self::assertSame(
            [
                PlayStopSerializerInterface::KEY_COMMAND => ['test-serialized-play-stop-command'],
                PlayStopSerializerInterface::KEY_STATE => ['test-serialized-play-stop-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
