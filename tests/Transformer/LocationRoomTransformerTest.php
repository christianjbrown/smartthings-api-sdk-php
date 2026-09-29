<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationRoom;
use ChristianBrown\SmartThings\Transformer\LocationRoomDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationRoom::class)]
#[CoversClass(LocationRoomTransformer::class)]
final class LocationRoomTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LocationRoomTransformerInterface::KEY_ROOM_ID => 'test-room-id',
            LocationRoomTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            LocationRoomTransformerInterface::KEY_NAME => 'test-name',
        ];

        $transformer = new LocationRoomTransformer(self::createStub(LocationRoomDetailsTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($data[LocationRoomTransformerInterface::KEY_ROOM_ID], $actual->getRoomId());
        self::assertSame($data[LocationRoomTransformerInterface::KEY_LOCATION_ID], $actual->getLocationId());
        self::assertSame($data[LocationRoomTransformerInterface::KEY_NAME], $actual->getName());
    }

    /**
     * Exercises every combination of the two optional fields (locationId, name),
     * each in one of three states: absent, present-but-wrong-type, or
     * present-and-valid. This covers all paths through both optional blocks.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedLocationId, ?string $expectedName): void
    {
        $transformer = new LocationRoomTransformer(self::createStub(LocationRoomDetailsTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame('test-room-id', $actual->getRoomId());
        self::assertSame($expectedLocationId, $actual->getLocationId());
        self::assertSame($expectedName, $actual->getName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $locationIdStates = [
            'locationIdAbsent' => [null, null],
            'locationIdWrongType' => [42, null],
            'locationIdValid' => ['test-location-id', 'test-location-id'],
        ];
        $nameStates = [
            'nameAbsent' => [null, null],
            'nameWrongType' => [42, null],
            'nameValid' => ['test-name', 'test-name'],
        ];

        foreach ($locationIdStates as $locationIdName => [$locationIdValue, $expectedLocationId]) {
            foreach ($nameStates as $nameName => [$nameValue, $expectedName]) {
                $data = [LocationRoomTransformerInterface::KEY_ROOM_ID => 'test-room-id'];
                if (null !== $locationIdValue) {
                    $data[LocationRoomTransformerInterface::KEY_LOCATION_ID] = $locationIdValue;
                }
                if (null !== $nameValue) {
                    $data[LocationRoomTransformerInterface::KEY_NAME] = $nameValue;
                }

                yield sprintf('%s, %s', $locationIdName, $nameName) => [
                    $data,
                    $expectedLocationId,
                    $expectedName,
                ];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[LocationRoomTransformerInterface::KEY_ROOM_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new LocationRoomTransformer(self::createStub(LocationRoomDetailsTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationRoomTransformerInterface::UNEXPECTED_STRING_SPRINTF, LocationRoomTransformerInterface::KEY_ROOM_ID));
        $transformer->transform($data);
    }
}
