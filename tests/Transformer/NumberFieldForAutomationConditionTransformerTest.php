<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationCondition;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(NumberFieldForAutomationCondition::class)]
#[CoversClass(NumberFieldForAutomationConditionTransformer::class)]
final class NumberFieldForAutomationConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value',
            NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            NumberFieldForAutomationConditionTransformerInterface::KEY_UNIT => 'test-unit',
            NumberFieldForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            NumberFieldForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            NumberFieldForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            NumberFieldForAutomationConditionTransformerInterface::KEY_DESCRIPTION => 'test-description',
        ];

        $transformer = new NumberFieldForAutomationConditionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-description', $actual->getDescription());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new NumberFieldForAutomationConditionTransformer($alternativeItemTransformer);
        $base = [NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [NumberFieldForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [NumberFieldForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new NumberFieldForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new NumberFieldForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[NumberFieldForAutomationConditionTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new NumberFieldForAutomationConditionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([NumberFieldForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getDescription());
    }
}
