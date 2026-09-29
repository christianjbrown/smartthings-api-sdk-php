<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationCondition;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListForAutomationCondition::class)]
#[CoversClass(ListForAutomationConditionTransformer::class)]
final class ListForAutomationConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            ListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value',
            ListForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ListForAutomationConditionTransformerInterface::KEY_MULTI_SELECTABLE => true,
        ];

        $transformer = new ListForAutomationConditionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertTrue($actual->getMultiSelectable());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ListForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[ListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[ListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[ListForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[ListForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'multiSelectableAbsent' => [[], 'getMultiSelectable', null];
        yield 'multiSelectableWrongType' => [[ListForAutomationConditionTransformerInterface::KEY_MULTI_SELECTABLE => 'not-bool'], 'getMultiSelectable', null];
        yield 'multiSelectableValid' => [[ListForAutomationConditionTransformerInterface::KEY_MULTI_SELECTABLE => true], 'getMultiSelectable', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new ListForAutomationConditionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getMultiSelectable());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'alternativesAbsent' => [[ListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'], sprintf(ListForAutomationConditionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES)];
        yield 'alternativesWrongType' => [[ListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => 'not-array'], sprintf(ListForAutomationConditionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES)];
        yield 'valueAbsent' => [[ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested']], sprintf(ListForAutomationConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForAutomationConditionTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[ListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], ListForAutomationConditionTransformerInterface::KEY_VALUE => 42], sprintf(ListForAutomationConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForAutomationConditionTransformerInterface::KEY_VALUE)];
    }
}
