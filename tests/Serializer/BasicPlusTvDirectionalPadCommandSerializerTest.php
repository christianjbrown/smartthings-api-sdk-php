<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommand;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadCommandSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadCommandSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvDirectionalPadCommand::class)]
#[CoversClass(BasicPlusTvDirectionalPadCommandSerializer::class)]
final class BasicPlusTvDirectionalPadCommandSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new BasicPlusTvDirectionalPadCommand('test-up', 'test-down', 'test-left', 'test-right', 'test-ok');

        $serializer = new BasicPlusTvDirectionalPadCommandSerializer();

        self::assertSame(
            [
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_UP => 'test-up',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_DOWN => 'test-down',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_LEFT => 'test-left',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_RIGHT => 'test-right',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_OK => 'test-ok',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new BasicPlusTvDirectionalPadCommand('test-up', 'test-down', 'test-left', 'test-right', 'test-ok'))
            ->setName('test-name');

        $serializer = new BasicPlusTvDirectionalPadCommandSerializer();

        self::assertSame(
            [
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_NAME => 'test-name',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_UP => 'test-up',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_DOWN => 'test-down',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_LEFT => 'test-left',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_RIGHT => 'test-right',
                BasicPlusTvDirectionalPadCommandSerializerInterface::KEY_OK => 'test-ok',
            ],
            $serializer->serialize($model)
        );
    }
}
