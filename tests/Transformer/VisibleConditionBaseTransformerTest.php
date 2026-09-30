<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionBase;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionBase::class)]
#[CoversClass(VisibleConditionBaseTransformer::class)]
final class VisibleConditionBaseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value',
            VisibleConditionBaseTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator',
            VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand',
        ];

        $transformer = new VisibleConditionBaseTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-operand', $actual->getOperand());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionBaseTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand'], 'getValue', null];
        yield 'valueWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionBaseTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'operatorAbsent' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand'], 'getOperator', null];
        yield 'operatorWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operandAbsent' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperand', null];
        yield 'operandWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 42], 'getOperand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionBaseTransformer();

        $actual = $transformer->transform([VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new VisibleConditionBaseTransformer();

        $actual = $transformer->transform([VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand']);

        self::assertNull($actual->getValueType());
    }
}
