<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\RoomIndoorMap;
use ChristianBrown\SmartThings\Transformer\RoomIndoorMapTransformer;
use ChristianBrown\SmartThings\Transformer\RoomIndoorMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(RoomIndoorMap::class)]
#[CoversClass(RoomIndoorMapTransformer::class)]
final class RoomIndoorMapTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RoomIndoorMapTransformerInterface::KEY_MAP_ROOM_ID => 'test-map-room-id',
            RoomIndoorMapTransformerInterface::KEY_COLOR => 'test-color',
        ];

        $transformer = new RoomIndoorMapTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-map-room-id', $actual->getMapRoomId());
        self::assertSame('test-color', $actual->getColor());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new RoomIndoorMapTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'mapRoomIdAbsent' => [[], 'getMapRoomId', null];
        yield 'mapRoomIdWrongType' => [[RoomIndoorMapTransformerInterface::KEY_MAP_ROOM_ID => 42], 'getMapRoomId', null];
        yield 'mapRoomIdValid' => [[RoomIndoorMapTransformerInterface::KEY_MAP_ROOM_ID => 'test-map-room-id'], 'getMapRoomId', 'test-map-room-id'];
        yield 'colorAbsent' => [[], 'getColor', null];
        yield 'colorWrongType' => [[RoomIndoorMapTransformerInterface::KEY_COLOR => 42], 'getColor', null];
        yield 'colorValid' => [[RoomIndoorMapTransformerInterface::KEY_COLOR => 'test-color'], 'getColor', 'test-color'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new RoomIndoorMapTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getMapRoomId());
        self::assertNull($actual->getColor());
    }
}
