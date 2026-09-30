<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\TextFieldForArgument;
use ChristianBrown\SmartThings\Transformer\TextFieldForArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextFieldForArgument::class)]
#[CoversClass(TextFieldForArgumentTransformer::class)]
final class TextFieldForArgumentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TextFieldForArgumentTransformerInterface::KEY_NAME => 'test-name',
            TextFieldForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            TextFieldForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
        ];

        $transformer = new TextFieldForArgumentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new TextFieldForArgumentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[TextFieldForArgumentTransformerInterface::KEY_NAME => 42], 'getName', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TextFieldForArgumentTransformer();

        $actual = $transformer->transform([TextFieldForArgumentTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[TextFieldForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[TextFieldForArgumentTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[TextFieldForArgumentTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[TextFieldForArgumentTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new TextFieldForArgumentTransformer();

        $actual = $transformer->transform([TextFieldForArgumentTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getRange());
    }
}
