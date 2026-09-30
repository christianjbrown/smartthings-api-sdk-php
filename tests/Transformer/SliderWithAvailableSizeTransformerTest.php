<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderWithAvailableSize;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\SliderWithAvailableSizeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderWithAvailableSize::class)]
#[CoversClass(SliderWithAvailableSizeTransformer::class)]
final class SliderWithAvailableSizeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            SliderWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderWithAvailableSizeTransformerInterface::KEY_STEP => 1.5,
            SliderWithAvailableSizeTransformerInterface::KEY_UNIT => 'test-unit',
            SliderWithAvailableSizeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderWithAvailableSizeTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command',
            SliderWithAvailableSizeTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            SliderWithAvailableSizeTransformerInterface::KEY_VALUE => 'test-value',
            SliderWithAvailableSizeTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            SliderWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
        ];

        $transformer = new SliderWithAvailableSizeTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame(['test-available-sizes-1', 'test-available-sizes-2'], $actual->getAvailableSizes());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderWithAvailableSizeTransformer($alternativeItemTransformer);
        $base = [SliderWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [SliderWithAvailableSizeTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [SliderWithAvailableSizeTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SliderWithAvailableSizeTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'rangeAbsent' => [[SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command'], 'getRange', []];
        yield 'rangeWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command', SliderWithAvailableSizeTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', []];
        yield 'commandAbsent' => [[SliderWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getCommand', null];
        yield 'commandWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderWithAvailableSizeTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([SliderWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'availableSizesAbsent' => [[], 'getAvailableSizes', null];
        yield 'availableSizesWrongType' => [[SliderWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => 'not-array'], 'getAvailableSizes', null];
        yield 'availableSizesValid' => [[SliderWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2']], 'getAvailableSizes', ['test-available-sizes-1', 'test-available-sizes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderWithAvailableSizeTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([SliderWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderWithAvailableSizeTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getAvailableSizes());
    }
}
