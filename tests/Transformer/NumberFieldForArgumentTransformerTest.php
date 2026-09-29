<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\NumberFieldForArgument;
use ChristianBrown\SmartThings\Transformer\NumberFieldForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NumberFieldForArgument::class)]
#[CoversClass(NumberFieldForArgumentTransformer::class)]
final class NumberFieldForArgumentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            NumberFieldForArgumentTransformerInterface::KEY_NAME => 'test-name',
            NumberFieldForArgumentTransformerInterface::KEY_UNIT => 'test-unit',
            NumberFieldForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            NumberFieldForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            NumberFieldForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new NumberFieldForArgumentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new NumberFieldForArgumentTransformer();

        $actual = $transformer->transform([NumberFieldForArgumentTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[NumberFieldForArgumentTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[NumberFieldForArgumentTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[NumberFieldForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[NumberFieldForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[NumberFieldForArgumentTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[NumberFieldForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[NumberFieldForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[NumberFieldForArgumentTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new NumberFieldForArgumentTransformer();

        $actual = $transformer->transform([NumberFieldForArgumentTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getUnit());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new NumberFieldForArgumentTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'nameAbsent' => [[], sprintf(NumberFieldForArgumentTransformerInterface::UNEXPECTED_STRING_SPRINTF, NumberFieldForArgumentTransformerInterface::KEY_NAME)];
        yield 'nameWrongType' => [[NumberFieldForArgumentTransformerInterface::KEY_NAME => 42], sprintf(NumberFieldForArgumentTransformerInterface::UNEXPECTED_STRING_SPRINTF, NumberFieldForArgumentTransformerInterface::KEY_NAME)];
    }
}
