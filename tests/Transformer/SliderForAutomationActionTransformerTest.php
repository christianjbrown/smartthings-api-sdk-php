<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationAction;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationActionTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationActionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderForAutomationAction::class)]
#[CoversClass(SliderForAutomationActionTransformer::class)]
final class SliderForAutomationActionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            SliderForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderForAutomationActionTransformerInterface::KEY_STEP => 1.5,
            SliderForAutomationActionTransformerInterface::KEY_UNIT => 'test-unit',
            SliderForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderForAutomationActionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            SliderForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command',
            SliderForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new SliderForAutomationActionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument-type', $actual->getArgumentType());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForAutomationActionTransformer($alternativeItemTransformer);
        $base = [SliderForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [SliderForAutomationActionTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [SliderForAutomationActionTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SliderForAutomationActionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'rangeAbsent' => [[SliderForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'], 'getRange', []];
        yield 'rangeWrongType' => [[SliderForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command', SliderForAutomationActionTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', []];
        yield 'commandAbsent' => [[SliderForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getCommand', null];
        yield 'commandWrongType' => [[SliderForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationActionTransformerInterface::KEY_COMMAND => 42], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderForAutomationActionTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([SliderForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderForAutomationActionTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderForAutomationActionTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderForAutomationActionTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderForAutomationActionTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderForAutomationActionTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[SliderForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[SliderForAutomationActionTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new SliderForAutomationActionTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([SliderForAutomationActionTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForAutomationActionTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getArgumentType());
    }
}
