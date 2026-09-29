<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationCondition;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SliderForAutomationCondition::class)]
#[CoversClass(SliderForAutomationConditionTransformer::class)]
final class SliderForAutomationConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            SliderForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderForAutomationConditionTransformerInterface::KEY_STEP => 1.5,
            SliderForAutomationConditionTransformerInterface::KEY_UNIT => 'test-unit',
            SliderForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            SliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value',
            SliderForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
        ];

        $transformer = new SliderForAutomationConditionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForAutomationConditionTransformer($alternativeItemTransformer);
        $base = [SliderForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [SliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [SliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([SliderForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderForAutomationConditionTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderForAutomationConditionTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderForAutomationConditionTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderForAutomationConditionTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[SliderForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[SliderForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForAutomationConditionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([SliderForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getValueType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new SliderForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'rangeAbsent' => [[SliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'], sprintf(SliderForAutomationConditionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SliderForAutomationConditionTransformerInterface::KEY_RANGE)];
        yield 'rangeWrongType' => [[SliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', SliderForAutomationConditionTransformerInterface::KEY_RANGE => 'not-array'], sprintf(SliderForAutomationConditionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SliderForAutomationConditionTransformerInterface::KEY_RANGE)];
        yield 'valueAbsent' => [[SliderForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], sprintf(SliderForAutomationConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForAutomationConditionTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[SliderForAutomationConditionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationConditionTransformerInterface::KEY_VALUE => 42], sprintf(SliderForAutomationConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForAutomationConditionTransformerInterface::KEY_VALUE)];
    }
}
