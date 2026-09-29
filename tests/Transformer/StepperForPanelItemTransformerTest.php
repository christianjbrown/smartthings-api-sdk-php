<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\StepperForPanelItem;
use ChristianBrown\SmartThings\Model\StepperForPanelItemCommandInterface;
use ChristianBrown\SmartThings\Model\StepperForPanelItemStateInterface;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(StepperForPanelItem::class)]
#[CoversClass(StepperForPanelItemTransformer::class)]
final class StepperForPanelItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $stepperForPanelItemCommandModel = self::createStub(StepperForPanelItemCommandInterface::class);
        $stepperForPanelItemCommandTransformer = self::createStub(StepperForPanelItemCommandTransformerInterface::class);
        $stepperForPanelItemCommandTransformer->method('transform')->willReturn($stepperForPanelItemCommandModel);
        $stepperForPanelItemStateModel = self::createStub(StepperForPanelItemStateInterface::class);
        $stepperForPanelItemStateTransformer = self::createStub(StepperForPanelItemStateTransformerInterface::class);
        $stepperForPanelItemStateTransformer->method('transform')->willReturn($stepperForPanelItemStateModel);
        $data = [
            StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'],
            StepperForPanelItemTransformerInterface::KEY_STEP => 1.5,
            StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            StepperForPanelItemTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'],
            StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size',
        ];

        $transformer = new StepperForPanelItemTransformer($stepperForPanelItemCommandTransformer, $stepperForPanelItemStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($stepperForPanelItemCommandModel, $actual->getCommand());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame($stepperForPanelItemStateModel, $actual->getState());
        self::assertSame('test-size', $actual->getSize());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StepperForPanelItemTransformer(self::createStub(StepperForPanelItemCommandTransformerInterface::class), self::createStub(StepperForPanelItemStateTransformerInterface::class));

        $actual = $transformer->transform([StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[StepperForPanelItemTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[StepperForPanelItemTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $stepperForPanelItemCommandModel = self::createStub(StepperForPanelItemCommandInterface::class);
        $stepperForPanelItemCommandTransformer = self::createStub(StepperForPanelItemCommandTransformerInterface::class);
        $stepperForPanelItemCommandTransformer->method('transform')->willReturn($stepperForPanelItemCommandModel);
        $stepperForPanelItemStateModel = self::createStub(StepperForPanelItemStateInterface::class);
        $stepperForPanelItemStateTransformer = self::createStub(StepperForPanelItemStateTransformerInterface::class);
        $stepperForPanelItemStateTransformer->method('transform')->willReturn($stepperForPanelItemStateModel);
        $transformer = new StepperForPanelItemTransformer($stepperForPanelItemCommandTransformer, $stepperForPanelItemStateTransformer);

        $actual = $transformer->transform([StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size']);

        self::assertNull($actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new StepperForPanelItemTransformer(self::createStub(StepperForPanelItemCommandTransformerInterface::class), self::createStub(StepperForPanelItemStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperForPanelItemTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size', StepperForPanelItemTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperForPanelItemTransformerInterface::KEY_COMMAND)];
        yield 'stepAbsent' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_NUMBER_SPRINTF, StepperForPanelItemTransformerInterface::KEY_STEP)];
        yield 'stepWrongType' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size', StepperForPanelItemTransformerInterface::KEY_STEP => 'not-number'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_NUMBER_SPRINTF, StepperForPanelItemTransformerInterface::KEY_STEP)];
        yield 'rangeAbsent' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperForPanelItemTransformerInterface::KEY_RANGE)];
        yield 'rangeWrongType' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size', StepperForPanelItemTransformerInterface::KEY_RANGE => 'not-array'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperForPanelItemTransformerInterface::KEY_RANGE)];
        yield 'stateAbsent' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperForPanelItemTransformerInterface::KEY_STATE)];
        yield 'stateWrongType' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_SIZE => 'test-size', StepperForPanelItemTransformerInterface::KEY_STATE => 'not-array'], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, StepperForPanelItemTransformerInterface::KEY_STATE)];
        yield 'sizeAbsent' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested']], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, StepperForPanelItemTransformerInterface::KEY_SIZE)];
        yield 'sizeWrongType' => [[StepperForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_STEP => 1.5, StepperForPanelItemTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], StepperForPanelItemTransformerInterface::KEY_STATE => ['test-nested'], StepperForPanelItemTransformerInterface::KEY_SIZE => 42], sprintf(StepperForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, StepperForPanelItemTransformerInterface::KEY_SIZE)];
    }
}
