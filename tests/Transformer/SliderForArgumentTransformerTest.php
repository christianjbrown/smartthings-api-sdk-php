<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForArgument;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderForArgument::class)]
#[CoversClass(SliderForArgumentTransformer::class)]
final class SliderForArgumentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            SliderForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderForArgumentTransformerInterface::KEY_STEP => 1.5,
            SliderForArgumentTransformerInterface::KEY_UNIT => 'test-unit',
            SliderForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderForArgumentTransformerInterface::KEY_NAME => 'test-name',
            SliderForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            SliderForArgumentTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new SliderForArgumentTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForArgumentTransformer($alternativeItemTransformer);
        $base = [SliderForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForArgumentTransformerInterface::KEY_NAME => 'test-name'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [SliderForArgumentTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [SliderForArgumentTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SliderForArgumentTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'rangeAbsent' => [[SliderForArgumentTransformerInterface::KEY_NAME => 'test-name'], 'getRange', []];
        yield 'rangeWrongType' => [[SliderForArgumentTransformerInterface::KEY_NAME => 'test-name', SliderForArgumentTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', []];
        yield 'nameAbsent' => [[SliderForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getName', null];
        yield 'nameWrongType' => [[SliderForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForArgumentTransformerInterface::KEY_NAME => 42], 'getName', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderForArgumentTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([SliderForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForArgumentTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderForArgumentTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderForArgumentTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderForArgumentTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderForArgumentTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[SliderForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[SliderForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForArgumentTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([SliderForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForArgumentTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getAlternatives());
    }
}
