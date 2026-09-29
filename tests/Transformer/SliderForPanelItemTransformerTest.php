<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForPanelItem;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SliderForPanelItem::class)]
#[CoversClass(SliderForPanelItemTransformer::class)]
final class SliderForPanelItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderForPanelItemTransformerInterface::KEY_STEP => 1.5,
            SliderForPanelItemTransformerInterface::KEY_UNIT => 'test-unit',
            SliderForPanelItemTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderForPanelItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command',
            SliderForPanelItemTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            SliderForPanelItemTransformerInterface::KEY_VALUE => 'test-value',
            SliderForPanelItemTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size',
        ];

        $transformer = new SliderForPanelItemTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-size', $actual->getSize());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForPanelItemTransformer($alternativeItemTransformer);
        $base = [SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [SliderForPanelItemTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [SliderForPanelItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderForPanelItemTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderForPanelItemTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderForPanelItemTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderForPanelItemTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderForPanelItemTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderForPanelItemTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderForPanelItemTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[SliderForPanelItemTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[SliderForPanelItemTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[SliderForPanelItemTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[SliderForPanelItemTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[SliderForPanelItemTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[SliderForPanelItemTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForPanelItemTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size']);

        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getArgumentType());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getValueType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new SliderForPanelItemTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'rangeAbsent' => [[SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(SliderForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SliderForPanelItemTransformerInterface::KEY_RANGE)];
        yield 'rangeWrongType' => [[SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size', SliderForPanelItemTransformerInterface::KEY_RANGE => 'not-array'], sprintf(SliderForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SliderForPanelItemTransformerInterface::KEY_RANGE)];
        yield 'commandAbsent' => [[SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(SliderForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForPanelItemTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_SIZE => 'test-size', SliderForPanelItemTransformerInterface::KEY_COMMAND => 42], sprintf(SliderForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForPanelItemTransformerInterface::KEY_COMMAND)];
        yield 'sizeAbsent' => [[SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command'], sprintf(SliderForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForPanelItemTransformerInterface::KEY_SIZE)];
        yield 'sizeWrongType' => [[SliderForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForPanelItemTransformerInterface::KEY_COMMAND => 'test-command', SliderForPanelItemTransformerInterface::KEY_SIZE => 42], sprintf(SliderForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForPanelItemTransformerInterface::KEY_SIZE)];
    }
}
