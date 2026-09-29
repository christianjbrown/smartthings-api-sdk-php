<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleConditionBase;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new VisibleConditionBaseTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand'], sprintf(VisibleConditionBaseTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionBaseTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionBaseTransformerInterface::KEY_VALUE => 42], sprintf(VisibleConditionBaseTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionBaseTransformerInterface::KEY_VALUE)];
        yield 'operatorAbsent' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand'], sprintf(VisibleConditionBaseTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionBaseTransformerInterface::KEY_OPERATOR)];
        yield 'operatorWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 42], sprintf(VisibleConditionBaseTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionBaseTransformerInterface::KEY_OPERATOR)];
        yield 'operandAbsent' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator'], sprintf(VisibleConditionBaseTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionBaseTransformerInterface::KEY_OPERAND)];
        yield 'operandWrongType' => [[VisibleConditionBaseTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionBaseTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionBaseTransformerInterface::KEY_OPERAND => 42], sprintf(VisibleConditionBaseTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionBaseTransformerInterface::KEY_OPERAND)];
    }
}
