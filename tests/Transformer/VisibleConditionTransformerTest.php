<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleCondition;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(VisibleCondition::class)]
#[CoversClass(VisibleConditionTransformer::class)]
final class VisibleConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            VisibleConditionTransformerInterface::KEY_VALUE => 'test-value',
            VisibleConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator',
            VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand',
            VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component',
            VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability',
            VisibleConditionTransformerInterface::KEY_VERSION => 7,
        ];

        $transformer = new VisibleConditionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-operand', $actual->getOperand());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionTransformer();

        $actual = $transformer->transform([VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[VisibleConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[VisibleConditionTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[VisibleConditionTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new VisibleConditionTransformer();

        $actual = $transformer->transform([VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getVersion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new VisibleConditionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_VALUE => 42], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_VALUE)];
        yield 'operatorAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_OPERATOR)];
        yield 'operatorWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_OPERATOR => 42], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_OPERATOR)];
        yield 'operandAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_OPERAND)];
        yield 'operandWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_OPERAND => 42], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_OPERAND)];
        yield 'componentAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_COMPONENT => 42], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 42], sprintf(VisibleConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionTransformerInterface::KEY_CAPABILITY)];
    }
}
