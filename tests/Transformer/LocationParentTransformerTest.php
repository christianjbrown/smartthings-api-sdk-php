<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LocationParent;
use ChristianBrown\SmartThings\Transformer\LocationParentTransformer;
use ChristianBrown\SmartThings\Transformer\LocationParentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationParent::class)]
#[CoversClass(LocationParentTransformer::class)]
final class LocationParentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LocationParentTransformerInterface::KEY_TYPE => 'test-type',
            LocationParentTransformerInterface::KEY_ID => 'test-id',
        ];

        $transformer = new LocationParentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-type', $actual->getType());
        self::assertSame('test-id', $actual->getId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new LocationParentTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[LocationParentTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[LocationParentTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[LocationParentTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'idValid' => [[LocationParentTransformerInterface::KEY_ID => 'test-id'], 'getId', 'test-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new LocationParentTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getType());
        self::assertNull($actual->getId());
    }
}
