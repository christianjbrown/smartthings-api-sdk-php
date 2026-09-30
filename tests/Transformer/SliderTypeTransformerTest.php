<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderType;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderTypeTransformer;
use ChristianBrown\SmartThings\Transformer\SliderTypeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderType::class)]
#[CoversClass(SliderTypeTransformer::class)]
final class SliderTypeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            SliderTypeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderTypeTransformerInterface::KEY_STEP => 1.5,
            SliderTypeTransformerInterface::KEY_UNIT => 'test-unit',
            SliderTypeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderTypeTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            SliderTypeTransformerInterface::KEY_COMMAND => 'test-command',
            SliderTypeTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            SliderTypeTransformerInterface::KEY_VALUE => 'test-value',
            SliderTypeTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
        ];

        $transformer = new SliderTypeTransformer($alternativeItemTransformer);

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
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderTypeTransformer($alternativeItemTransformer);
        $base = [SliderTypeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [SliderTypeTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [SliderTypeTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SliderTypeTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'rangeAbsent' => [[], 'getRange', []];
        yield 'rangeWrongType' => [[SliderTypeTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderTypeTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([SliderTypeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderTypeTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderTypeTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderTypeTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderTypeTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderTypeTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderTypeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[SliderTypeTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
        yield 'commandValid' => [[SliderTypeTransformerInterface::KEY_COMMAND => 'test-command'], 'getCommand', 'test-command'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[SliderTypeTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[SliderTypeTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[SliderTypeTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[SliderTypeTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[SliderTypeTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[SliderTypeTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderTypeTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([SliderTypeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']]);

        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getCommand());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getValueType());
    }
}
