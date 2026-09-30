<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSize;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeStateInterface;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperWithAvailableSize::class)]
#[CoversClass(StepperWithAvailableSizeTransformer::class)]
final class StepperWithAvailableSizeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandTransformer = self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class);
        $stepperWithAvailableSizeCommandTransformer->method('transform')->willReturn($stepperWithAvailableSizeCommandModel);
        $stepperWithAvailableSizeStateModel = self::createStub(StepperWithAvailableSizeStateInterface::class);
        $stepperWithAvailableSizeStateTransformer = self::createStub(StepperWithAvailableSizeStateTransformerInterface::class);
        $stepperWithAvailableSizeStateTransformer->method('transform')->willReturn($stepperWithAvailableSizeStateModel);
        $data = [
            StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'],
            StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5,
            StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            StepperWithAvailableSizeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested'],
            StepperWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
        ];

        $transformer = new StepperWithAvailableSizeTransformer($stepperWithAvailableSizeCommandTransformer, $stepperWithAvailableSizeStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($stepperWithAvailableSizeCommandModel, $actual->getCommand());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame($stepperWithAvailableSizeStateModel, $actual->getState());
        self::assertSame(['test-available-sizes-1', 'test-available-sizes-2'], $actual->getAvailableSizes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new StepperWithAvailableSizeTransformer(self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class), self::createStub(StepperWithAvailableSizeStateTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested']], 'getCommand', null];
        yield 'commandWrongType' => [[StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
        yield 'stepAbsent' => [[StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested']], 'getStep', null];
        yield 'stepWrongType' => [[StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'rangeAbsent' => [[StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested']], 'getRange', []];
        yield 'rangeWrongType' => [[StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', []];
        yield 'stateAbsent' => [[StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getState', null];
        yield 'stateWrongType' => [[StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => 'not-array'], 'getState', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StepperWithAvailableSizeTransformer(self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class), self::createStub(StepperWithAvailableSizeStateTransformerInterface::class));

        $actual = $transformer->transform([StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[StepperWithAvailableSizeTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[StepperWithAvailableSizeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'availableSizesAbsent' => [[], 'getAvailableSizes', null];
        yield 'availableSizesWrongType' => [[StepperWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => 'not-array'], 'getAvailableSizes', null];
        yield 'availableSizesValid' => [[StepperWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2']], 'getAvailableSizes', ['test-available-sizes-1', 'test-available-sizes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandTransformer = self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class);
        $stepperWithAvailableSizeCommandTransformer->method('transform')->willReturn($stepperWithAvailableSizeCommandModel);
        $stepperWithAvailableSizeStateModel = self::createStub(StepperWithAvailableSizeStateInterface::class);
        $stepperWithAvailableSizeStateTransformer = self::createStub(StepperWithAvailableSizeStateTransformerInterface::class);
        $stepperWithAvailableSizeStateTransformer->method('transform')->willReturn($stepperWithAvailableSizeStateModel);
        $transformer = new StepperWithAvailableSizeTransformer($stepperWithAvailableSizeCommandTransformer, $stepperWithAvailableSizeStateTransformer);

        $actual = $transformer->transform([StepperWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'], StepperWithAvailableSizeTransformerInterface::KEY_STEP => 1.5, StepperWithAvailableSizeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested']]);

        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getAvailableSizes());
    }
}
