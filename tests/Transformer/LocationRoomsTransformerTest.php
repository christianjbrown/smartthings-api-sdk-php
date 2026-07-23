<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationRoomsTransformer::class)]
final class LocationRoomsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-room-1'], ['test-room-2']];

        $room1 = self::createStub(LocationRoomInterface::class);
        $room2 = self::createStub(LocationRoomInterface::class);
        $rooms = [$room1, $room2];

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-room-1'], $room1],
                    [['test-room-2'], $room2],
                ]
            );

        $transformer = new LocationRoomsTransformer($roomTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($rooms, $actual);
    }

    public function testTransformEmpty(): void
    {
        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);

        $transformer = new LocationRoomsTransformer($roomTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $room1 = self::createStub(LocationRoomInterface::class);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())->method('transform')
            ->with(['test-room-1'])
            ->willReturn($room1);

        $transformer = new LocationRoomsTransformer($roomTransformer);

        self::assertSame([$room1], $transformer->transform([['test-room-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);

        $transformer = new LocationRoomsTransformer($roomTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationRoomsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LocationRoomsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-room-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-room-1-array'], 'test-room-2-not-array', ['test-room-3-array'], 'test-room-4-not-array'];

        $room1 = self::createStub(LocationRoomInterface::class);
        $room3 = self::createStub(LocationRoomInterface::class);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-room-1-array'], $room1],
                    [['test-room-3-array'], $room3],
                ]
            );

        $transformer = new LocationRoomsTransformer($roomTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationRoomsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LocationRoomsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
