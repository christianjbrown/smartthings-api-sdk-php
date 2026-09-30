<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\VisibleCondition;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getValue', null];
        yield 'valueWrongType' => [[VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'operatorAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getOperator', null];
        yield 'operatorWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operandAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getOperand', null];
        yield 'operandWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_OPERAND => 42], 'getOperand', null];
        yield 'componentAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[VisibleConditionTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
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
}
