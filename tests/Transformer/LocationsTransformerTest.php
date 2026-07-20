<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationsTransformer::class)]
final class LocationsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-location-1'], ['test-location-2']];

        $location1 = self::createStub(LocationInterface::class);
        $location2 = self::createStub(LocationInterface::class);
        $locations = [$location1, $location2];

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-location-1'], $location1],
                    [['test-location-2'], $location2],
                ]
            );

        $transformer = new LocationsTransformer($locationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($locations, $actual);
    }

    public function testTransformEmpty(): void
    {
        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $transformer = new LocationsTransformer($locationTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $location1 = self::createStub(LocationInterface::class);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())->method('transform')
            ->with(['test-location-1'])
            ->willReturn($location1);

        $transformer = new LocationsTransformer($locationTransformer);

        self::assertSame([$location1], $transformer->transform([['test-location-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $transformer = new LocationsTransformer($locationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LocationsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-location-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-location-1-array'], 'test-location-2-not-array', ['test-location-3-array'], 'test-location-4-not-array'];

        $location1 = self::createStub(LocationInterface::class);
        $location3 = self::createStub(LocationInterface::class);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-location-1-array'], $location1],
                    [['test-location-3-array'], $location3],
                ]
            );

        $transformer = new LocationsTransformer($locationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LocationsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
