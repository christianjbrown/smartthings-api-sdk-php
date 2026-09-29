<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPad;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvDirectionalPad::class)]
#[CoversClass(BasicPlusTvDirectionalPadSerializer::class)]
final class BasicPlusTvDirectionalPadSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusTvDirectionalPadCommandModel = self::createStub(BasicPlusTvDirectionalPadCommandInterface::class);
        $basicPlusTvDirectionalPadCommandSerializer = self::createStub(BasicPlusTvDirectionalPadCommandSerializerInterface::class);
        $basicPlusTvDirectionalPadCommandSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-directional-pad-command']);
        $model = new BasicPlusTvDirectionalPad('test-capability', 'test-component', $basicPlusTvDirectionalPadCommandModel);

        $serializer = new BasicPlusTvDirectionalPadSerializer($basicPlusTvDirectionalPadCommandSerializer);

        self::assertSame(
            [
                BasicPlusTvDirectionalPadSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusTvDirectionalPadSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusTvDirectionalPadSerializerInterface::KEY_COMMAND => ['test-serialized-basic-plus-tv-directional-pad-command'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusTvDirectionalPadCommandModel = self::createStub(BasicPlusTvDirectionalPadCommandInterface::class);
        $basicPlusTvDirectionalPadCommandSerializer = self::createStub(BasicPlusTvDirectionalPadCommandSerializerInterface::class);
        $basicPlusTvDirectionalPadCommandSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-directional-pad-command']);
        $model = (new BasicPlusTvDirectionalPad('test-capability', 'test-component', $basicPlusTvDirectionalPadCommandModel))
            ->setVersion(7);

        $serializer = new BasicPlusTvDirectionalPadSerializer($basicPlusTvDirectionalPadCommandSerializer);

        self::assertSame(
            [
                BasicPlusTvDirectionalPadSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusTvDirectionalPadSerializerInterface::KEY_VERSION => 7,
                BasicPlusTvDirectionalPadSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusTvDirectionalPadSerializerInterface::KEY_COMMAND => ['test-serialized-basic-plus-tv-directional-pad-command'],
            ],
            $serializer->serialize($model)
        );
    }
}
