<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LocationRoomDetails;
use ChristianBrown\SmartThings\Model\RoomIndoorMapInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RoomIndoorMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationRoomDetails::class)]
#[CoversClass(LocationRoomDetailsTransformer::class)]
final class LocationRoomDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $roomIndoorMapModel = self::createStub(RoomIndoorMapInterface::class);
        $roomIndoorMapTransformer = self::createStub(RoomIndoorMapTransformerInterface::class);
        $roomIndoorMapTransformer->method('transform')->willReturn($roomIndoorMapModel);
        $data = [
            LocationRoomDetailsTransformerInterface::KEY_INDOOR_MAP => ['test-nested'],
        ];

        $transformer = new LocationRoomDetailsTransformer($roomIndoorMapTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($roomIndoorMapModel, $actual->getIndoorMap());
    }

    public function testTransformIndoorMap(): void
    {
        $roomIndoorMapModel = self::createStub(RoomIndoorMapInterface::class);
        $roomIndoorMapTransformer = self::createStub(RoomIndoorMapTransformerInterface::class);
        $roomIndoorMapTransformer->method('transform')->willReturn($roomIndoorMapModel);
        $transformer = new LocationRoomDetailsTransformer($roomIndoorMapTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getIndoorMap());
        self::assertNull($transformer->transform($base + [LocationRoomDetailsTransformerInterface::KEY_INDOOR_MAP => 'test-not-array'])->getIndoorMap());
        self::assertSame($roomIndoorMapModel, $transformer->transform($base + [LocationRoomDetailsTransformerInterface::KEY_INDOOR_MAP => ['test-nested']])->getIndoorMap());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $roomIndoorMapModel = self::createStub(RoomIndoorMapInterface::class);
        $roomIndoorMapTransformer = self::createStub(RoomIndoorMapTransformerInterface::class);
        $roomIndoorMapTransformer->method('transform')->willReturn($roomIndoorMapModel);
        $transformer = new LocationRoomDetailsTransformer($roomIndoorMapTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getIndoorMap());
    }
}
