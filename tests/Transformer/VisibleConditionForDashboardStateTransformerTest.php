<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardState;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForDashboardState::class)]
#[CoversClass(VisibleConditionForDashboardStateTransformer::class)]
final class VisibleConditionForDashboardStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value',
            VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator',
            VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand',
            VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component',
            VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability',
            VisibleConditionForDashboardStateTransformerInterface::KEY_VERSION => 7,
            VisibleConditionForDashboardStateTransformerInterface::KEY_IS_OFFLINE => true,
        ];

        $transformer = new VisibleConditionForDashboardStateTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-operand', $actual->getOperand());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertTrue($actual->getIsOffline());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionForDashboardStateTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getValue', null];
        yield 'valueWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'operatorAbsent' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getOperator', null];
        yield 'operatorWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operandAbsent' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getOperand', null];
        yield 'operandWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 42], 'getOperand', null];
        yield 'componentAbsent' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getComponent', null];
        yield 'componentWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCapability', null];
        yield 'capabilityWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionForDashboardStateTransformer();

        $actual = $transformer->transform([VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'isOfflineAbsent' => [[], 'getIsOffline', null];
        yield 'isOfflineWrongType' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_IS_OFFLINE => 'not-bool'], 'getIsOffline', null];
        yield 'isOfflineValid' => [[VisibleConditionForDashboardStateTransformerInterface::KEY_IS_OFFLINE => true], 'getIsOffline', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new VisibleConditionForDashboardStateTransformer();

        $actual = $transformer->transform([VisibleConditionForDashboardStateTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDashboardStateTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDashboardStateTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDashboardStateTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getIsOffline());
    }
}
