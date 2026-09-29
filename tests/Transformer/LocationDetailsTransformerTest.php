<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LocationDetails;
use ChristianBrown\SmartThings\Model\LocationParentInterface;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationParentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationDetails::class)]
#[CoversClass(LocationDetailsTransformer::class)]
final class LocationDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $locationParentModel = self::createStub(LocationParentInterface::class);
        $locationParentTransformer = self::createStub(LocationParentTransformerInterface::class);
        $locationParentTransformer->method('transform')->willReturn($locationParentModel);
        $data = [
            LocationDetailsTransformerInterface::KEY_PARENT => ['test-nested'],
        ];

        $transformer = new LocationDetailsTransformer($locationParentTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($locationParentModel, $actual->getParent());
    }

    public function testTransformParent(): void
    {
        $locationParentModel = self::createStub(LocationParentInterface::class);
        $locationParentTransformer = self::createStub(LocationParentTransformerInterface::class);
        $locationParentTransformer->method('transform')->willReturn($locationParentModel);
        $transformer = new LocationDetailsTransformer($locationParentTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getParent());
        self::assertNull($transformer->transform($base + [LocationDetailsTransformerInterface::KEY_PARENT => 'test-not-array'])->getParent());
        self::assertSame($locationParentModel, $transformer->transform($base + [LocationDetailsTransformerInterface::KEY_PARENT => ['test-nested']])->getParent());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $locationParentModel = self::createStub(LocationParentInterface::class);
        $locationParentTransformer = self::createStub(LocationParentTransformerInterface::class);
        $locationParentTransformer->method('transform')->willReturn($locationParentModel);
        $transformer = new LocationDetailsTransformer($locationParentTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getParent());
    }
}
