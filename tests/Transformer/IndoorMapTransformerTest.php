<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\IndoorMap;
use ChristianBrown\SmartThings\Transformer\IndoorMapTransformer;
use ChristianBrown\SmartThings\Transformer\IndoorMapTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IndoorMap::class)]
#[CoversClass(IndoorMapTransformer::class)]
final class IndoorMapTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            IndoorMapTransformerInterface::KEY_COORDINATES => ['test-coordinates-key' => 'test-value'],
            IndoorMapTransformerInterface::KEY_ROTATION => ['test-rotation-key' => 'test-value'],
            IndoorMapTransformerInterface::KEY_VISIBLE => true,
            IndoorMapTransformerInterface::KEY_DATA => ['test-data-key' => 'test-value'],
        ];

        $transformer = new IndoorMapTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['test-coordinates-key' => 'test-value'], $actual->getCoordinates());
        self::assertSame(['test-rotation-key' => 'test-value'], $actual->getRotation());
        self::assertTrue($actual->getVisible());
        self::assertSame(['test-data-key' => 'test-value'], $actual->getData());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new IndoorMapTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'coordinatesAbsent' => [[], 'getCoordinates', null];
        yield 'coordinatesWrongType' => [[IndoorMapTransformerInterface::KEY_COORDINATES => 'not-array'], 'getCoordinates', null];
        yield 'coordinatesValid' => [[IndoorMapTransformerInterface::KEY_COORDINATES => ['test-coordinates-key' => 'test-value']], 'getCoordinates', ['test-coordinates-key' => 'test-value']];
        yield 'rotationAbsent' => [[], 'getRotation', null];
        yield 'rotationWrongType' => [[IndoorMapTransformerInterface::KEY_ROTATION => 'not-array'], 'getRotation', null];
        yield 'rotationValid' => [[IndoorMapTransformerInterface::KEY_ROTATION => ['test-rotation-key' => 'test-value']], 'getRotation', ['test-rotation-key' => 'test-value']];
        yield 'visibleAbsent' => [[], 'getVisible', null];
        yield 'visibleWrongType' => [[IndoorMapTransformerInterface::KEY_VISIBLE => 'not-bool'], 'getVisible', null];
        yield 'visibleValid' => [[IndoorMapTransformerInterface::KEY_VISIBLE => true], 'getVisible', true];
        yield 'dataAbsent' => [[], 'getData', null];
        yield 'dataWrongType' => [[IndoorMapTransformerInterface::KEY_DATA => 'not-array'], 'getData', null];
        yield 'dataValid' => [[IndoorMapTransformerInterface::KEY_DATA => ['test-data-key' => 'test-value']], 'getData', ['test-data-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new IndoorMapTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getCoordinates());
        self::assertNull($actual->getRotation());
        self::assertNull($actual->getVisible());
        self::assertNull($actual->getData());
    }
}
