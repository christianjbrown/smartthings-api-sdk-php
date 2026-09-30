<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeStateTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperWithAvailableSizeState::class)]
#[CoversClass(StepperWithAvailableSizeStateTransformer::class)]
final class StepperWithAvailableSizeStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value',
            StepperWithAvailableSizeStateTransformerInterface::KEY_UNIT => 'test-unit',
            StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            StepperWithAvailableSizeStateTransformerInterface::KEY_LABEL => 'test-label',
            StepperWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new StepperWithAvailableSizeStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StepperWithAvailableSizeStateTransformer($alternativeItemTransformer);
        $base = [StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StepperWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StepperWithAvailableSizeStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new StepperWithAvailableSizeStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StepperWithAvailableSizeStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[StepperWithAvailableSizeStateTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StepperWithAvailableSizeStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([StepperWithAvailableSizeStateTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getUnit());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getAlternatives());
    }
}
