<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Location;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Location::class)]
#[CoversClass(LocationTransformer::class)]
final class LocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LocationTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            LocationTransformerInterface::KEY_NAME => 'test-name',
        ];

        $transformer = new LocationTransformer(self::createStub(LocationDetailsTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($data[LocationTransformerInterface::KEY_LOCATION_ID], $actual->getLocationId());
        self::assertSame($data[LocationTransformerInterface::KEY_NAME], $actual->getName());
    }

    /**
     * Exercises the optional name field in each of its three states: absent,
     * present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedName): void
    {
        $transformer = new LocationTransformer(self::createStub(LocationDetailsTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame($expectedName, $actual->getName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $nameStates = [
            'nameAbsent' => [null, null],
            'nameWrongType' => [42, null],
            'nameValid' => ['test-name', 'test-name'],
        ];

        foreach ($nameStates as $nameName => [$nameValue, $expectedName]) {
            $data = [LocationTransformerInterface::KEY_LOCATION_ID => 'test-location-id'];
            if (null !== $nameValue) {
                $data[LocationTransformerInterface::KEY_NAME] = $nameValue;
            }

            yield $nameName => [$data, $expectedName];
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[LocationTransformerInterface::KEY_LOCATION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new LocationTransformer(self::createStub(LocationDetailsTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationTransformerInterface::UNEXPECTED_STRING_SPRINTF, LocationTransformerInterface::KEY_LOCATION_ID));
        $transformer->transform($data);
    }
}
