<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\GroupVisibleConditions;
use ChristianBrown\SmartThings\Transformer\GroupVisibleConditionsTransformer;
use ChristianBrown\SmartThings\Transformer\GroupVisibleConditionsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(GroupVisibleConditions::class)]
#[CoversClass(GroupVisibleConditionsTransformer::class)]
final class GroupVisibleConditionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value',
            GroupVisibleConditionsTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator',
            GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand',
            GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component',
            GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability',
            GroupVisibleConditionsTransformerInterface::KEY_VERSION => 7,
        ];

        $transformer = new GroupVisibleConditionsTransformer();

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
        $transformer = new GroupVisibleConditionsTransformer();

        $actual = $transformer->transform([GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[GroupVisibleConditionsTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new GroupVisibleConditionsTransformer();

        $actual = $transformer->transform([GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getVersion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new GroupVisibleConditionsTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability', GroupVisibleConditionsTransformerInterface::KEY_VALUE => 42], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_VALUE)];
        yield 'operatorAbsent' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_OPERATOR)];
        yield 'operatorWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 42], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_OPERATOR)];
        yield 'operandAbsent' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_OPERAND)];
        yield 'operandWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 42], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_OPERAND)];
        yield 'componentAbsent' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 'test-capability', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 42], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[GroupVisibleConditionsTransformerInterface::KEY_VALUE => 'test-value', GroupVisibleConditionsTransformerInterface::KEY_OPERATOR => 'test-operator', GroupVisibleConditionsTransformerInterface::KEY_OPERAND => 'test-operand', GroupVisibleConditionsTransformerInterface::KEY_COMPONENT => 'test-component', GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY => 42], sprintf(GroupVisibleConditionsTransformerInterface::UNEXPECTED_STRING_SPRINTF, GroupVisibleConditionsTransformerInterface::KEY_CAPABILITY)];
    }
}
