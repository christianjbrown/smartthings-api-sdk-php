<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LocationRoom;
use ChristianBrown\SmartThings\Model\LocationRoomDetailsInterface;
use ChristianBrown\SmartThings\Model\RoomIndoorMapInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationRoom::class)]
#[CoversClass(LocationRoomTransformer::class)]
final class LocationRoomTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new LocationRoomTransformer(self::createStub(LocationRoomDetailsTransformerInterface::class));

        $actual = $transformer->transform([LocationRoomTransformerInterface::KEY_ROOM_ID => 'test-room-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'allowedAbsent' => [[], 'getAllowed', []];
        yield 'allowedWrongType' => [[LocationRoomTransformerInterface::KEY_ALLOWED => 'not-array'], 'getAllowed', []];
        yield 'allowedValid' => [[LocationRoomTransformerInterface::KEY_ALLOWED => ['test-allowed-1', 42, 'test-allowed-2']], 'getAllowed', ['test-allowed-1', 'test-allowed-2']];
        yield 'backgroundImageAbsent' => [[], 'getBackgroundImage', null];
        yield 'backgroundImageWrongType' => [[LocationRoomTransformerInterface::KEY_BACKGROUND_IMAGE => 42], 'getBackgroundImage', null];
        yield 'backgroundImageValid' => [[LocationRoomTransformerInterface::KEY_BACKGROUND_IMAGE => 'test-background-image'], 'getBackgroundImage', 'test-background-image'];
        yield 'createdAbsent' => [[], 'getCreated', null];
        yield 'createdWrongType' => [[LocationRoomTransformerInterface::KEY_CREATED => 42], 'getCreated', null];
        yield 'createdValid' => [[LocationRoomTransformerInterface::KEY_CREATED => 'test-created'], 'getCreated', 'test-created'];
        yield 'lastModifiedAbsent' => [[], 'getLastModified', null];
        yield 'lastModifiedWrongType' => [[LocationRoomTransformerInterface::KEY_LAST_MODIFIED => 42], 'getLastModified', null];
        yield 'lastModifiedValid' => [[LocationRoomTransformerInterface::KEY_LAST_MODIFIED => 'test-last-modified'], 'getLastModified', 'test-last-modified'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $indoorMap = self::createStub(RoomIndoorMapInterface::class);
        $details = self::createStub(LocationRoomDetailsInterface::class);
        $details->method('getIndoorMap')->willReturn($indoorMap);

        $data = [LocationRoomTransformerInterface::KEY_ROOM_ID => 'test-room-id'] + [LocationRoomTransformerInterface::KEY_INDOOR_MAP => []];
        $containerTransformer = self::createMock(LocationRoomDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new LocationRoomTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($indoorMap, $actual->getIndoorMap());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(LocationRoomDetailsInterface::class);
        $containerTransformer = self::createStub(LocationRoomDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new LocationRoomTransformer($containerTransformer);

        $actual = $transformer->transform([LocationRoomTransformerInterface::KEY_ROOM_ID => 'test-room-id'] + [LocationRoomTransformerInterface::KEY_INDOOR_MAP => []]);

        self::assertNull($actual->getIndoorMap());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(LocationRoomDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new LocationRoomTransformer($containerTransformer);

        $actual = $transformer->transform([LocationRoomTransformerInterface::KEY_ROOM_ID => 'test-room-id']);

        self::assertNull($actual->getIndoorMap());
    }
}
