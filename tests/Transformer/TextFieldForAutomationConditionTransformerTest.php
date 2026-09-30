<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationCondition;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextFieldForAutomationCondition::class)]
#[CoversClass(TextFieldForAutomationConditionTransformer::class)]
final class TextFieldForAutomationConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TextFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value',
            TextFieldForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            TextFieldForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
        ];

        $transformer = new TextFieldForAutomationConditionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new TextFieldForAutomationConditionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[TextFieldForAutomationConditionTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TextFieldForAutomationConditionTransformer();

        $actual = $transformer->transform([TextFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[TextFieldForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[TextFieldForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[TextFieldForAutomationConditionTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[TextFieldForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new TextFieldForAutomationConditionTransformer();

        $actual = $transformer->transform([TextFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getRange());
    }
}
