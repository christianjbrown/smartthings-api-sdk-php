<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Stepper;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Transformer\StepperTransformer;
use ChristianBrown\SmartThings\Transformer\StepperTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Stepper::class)]
#[CoversClass(StepperTransformer::class)]
final class StepperTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandTransformer = self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class);
        $stepperWithAvailableSizeCommandTransformer->method('transform')->willReturn($stepperWithAvailableSizeCommandModel);
        $data = [
            StepperTransformerInterface::KEY_COMMAND => ['test-nested'],
            StepperTransformerInterface::KEY_STEP => 1.5,
            StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            StepperTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            StepperTransformerInterface::KEY_VALUE => 'test-value',
            StepperTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
        ];

        $transformer = new StepperTransformer($stepperWithAvailableSizeCommandTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($stepperWithAvailableSizeCommandModel, $actual->getCommand());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StepperTransformer(self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class));

        $actual = $transformer->transform([StepperTransformerInterface::KEY_COMMAND => ['test-nested'], StepperTransformerInterface::KEY_STEP => 1.5, StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[StepperTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[StepperTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[StepperTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[StepperTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[StepperTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[StepperTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $stepperWithAvailableSizeCommandModel = self::createStub(StepperWithAvailableSizeCommandInterface::class);
        $stepperWithAvailableSizeCommandTransformer = self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class);
        $stepperWithAvailableSizeCommandTransformer->method('transform')->willReturn($stepperWithAvailableSizeCommandModel);
        $transformer = new StepperTransformer($stepperWithAvailableSizeCommandTransformer);

        $actual = $transformer->transform([StepperTransformerInterface::KEY_COMMAND => ['test-nested'], StepperTransformerInterface::KEY_STEP => 1.5, StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']]);

        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getValueType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new StepperTransformer(self::createStub(StepperWithAvailableSizeCommandTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[StepperTransformerInterface::KEY_STEP => 1.5, StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], sprintf(StepperTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[StepperTransformerInterface::KEY_STEP => 1.5, StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(StepperTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperTransformerInterface::KEY_COMMAND)];
        yield 'stepAbsent' => [[StepperTransformerInterface::KEY_COMMAND => ['test-nested'], StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], sprintf(StepperTransformerInterface::UNEXPECTED_NUMBER_SPRINTF, StepperTransformerInterface::KEY_STEP)];
        yield 'stepWrongType' => [[StepperTransformerInterface::KEY_COMMAND => ['test-nested'], StepperTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperTransformerInterface::KEY_STEP => 'not-number'], sprintf(StepperTransformerInterface::UNEXPECTED_NUMBER_SPRINTF, StepperTransformerInterface::KEY_STEP)];
        yield 'rangeAbsent' => [[StepperTransformerInterface::KEY_COMMAND => ['test-nested'], StepperTransformerInterface::KEY_STEP => 1.5], sprintf(StepperTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperTransformerInterface::KEY_RANGE)];
        yield 'rangeWrongType' => [[StepperTransformerInterface::KEY_COMMAND => ['test-nested'], StepperTransformerInterface::KEY_STEP => 1.5, StepperTransformerInterface::KEY_RANGE => 'not-array'], sprintf(StepperTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperTransformerInterface::KEY_RANGE)];
    }
}
