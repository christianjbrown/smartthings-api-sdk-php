<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\NumberField;
use ChristianBrown\SmartThings\Transformer\NumberFieldTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumberField::class)]
#[CoversClass(NumberFieldTransformer::class)]
final class NumberFieldTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            NumberFieldTransformerInterface::KEY_VALUE => 'test-value',
            NumberFieldTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            NumberFieldTransformerInterface::KEY_UNIT => 'test-unit',
            NumberFieldTransformerInterface::KEY_COMMAND => 'test-command',
            NumberFieldTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            NumberFieldTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            NumberFieldTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new NumberFieldTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new NumberFieldTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[], 'getCommand', null];
        yield 'commandWrongType' => [[NumberFieldTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new NumberFieldTransformer();

        $actual = $transformer->transform([NumberFieldTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[NumberFieldTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[NumberFieldTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[NumberFieldTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[NumberFieldTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[NumberFieldTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[NumberFieldTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[NumberFieldTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[NumberFieldTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[NumberFieldTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[NumberFieldTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[NumberFieldTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[NumberFieldTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new NumberFieldTransformer();

        $actual = $transformer->transform([NumberFieldTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getValue());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getSupportedValues());
    }
}
