<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommand;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvVolumeCommand::class)]
#[CoversClass(BasicPlusTvVolumeCommandSerializer::class)]
final class BasicPlusTvVolumeCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new BasicPlusTvVolumeCommand();

        $serializer = new BasicPlusTvVolumeCommandSerializer();

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new BasicPlusTvVolumeCommand())
            ->setName('test-name')
            ->setIncrease('test-increase')
            ->setDecrease('test-decrease');

        $serializer = new BasicPlusTvVolumeCommandSerializer();

        self::assertSame(
            [
                BasicPlusTvVolumeCommandSerializerInterface::KEY_NAME => 'test-name',
                BasicPlusTvVolumeCommandSerializerInterface::KEY_INCREASE => 'test-increase',
                BasicPlusTvVolumeCommandSerializerInterface::KEY_DECREASE => 'test-decrease',
            ],
            $serializer->serialize($model)
        );
    }
}
