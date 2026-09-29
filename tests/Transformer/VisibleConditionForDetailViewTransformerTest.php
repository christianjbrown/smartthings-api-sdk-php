<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailView;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDetailViewTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(VisibleConditionForDetailView::class)]
#[CoversClass(VisibleConditionForDetailViewTransformer::class)]
final class VisibleConditionForDetailViewTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value',
            VisibleConditionForDetailViewTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator',
            VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand',
            VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component',
            VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability',
            VisibleConditionForDetailViewTransformerInterface::KEY_VERSION => 7,
            VisibleConditionForDetailViewTransformerInterface::KEY_HIDE_ON_UNMATCH => true,
        ];

        $transformer = new VisibleConditionForDetailViewTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame('test-operand', $actual->getOperand());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertTrue($actual->getHideOnUnmatch());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionForDetailViewTransformer();

        $actual = $transformer->transform([VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'hideOnUnmatchAbsent' => [[], 'getHideOnUnmatch', null];
        yield 'hideOnUnmatchWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_HIDE_ON_UNMATCH => 'not-bool'], 'getHideOnUnmatch', null];
        yield 'hideOnUnmatchValid' => [[VisibleConditionForDetailViewTransformerInterface::KEY_HIDE_ON_UNMATCH => true], 'getHideOnUnmatch', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new VisibleConditionForDetailViewTransformer();

        $actual = $transformer->transform([VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getHideOnUnmatch());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new VisibleConditionForDetailViewTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 42], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_VALUE)];
        yield 'operatorAbsent' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR)];
        yield 'operatorWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 42], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR)];
        yield 'operandAbsent' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND)];
        yield 'operandWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 42], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND)];
        yield 'componentAbsent' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 42], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[VisibleConditionForDetailViewTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForDetailViewTransformerInterface::KEY_OPERATOR => 'test-operator', VisibleConditionForDetailViewTransformerInterface::KEY_OPERAND => 'test-operand', VisibleConditionForDetailViewTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY => 42], sprintf(VisibleConditionForDetailViewTransformerInterface::UNEXPECTED_STRING_SPRINTF, VisibleConditionForDetailViewTransformerInterface::KEY_CAPABILITY)];
    }
}
