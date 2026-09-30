<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StepperForPanelItemState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemStateTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperForPanelItemState::class)]
#[CoversClass(StepperForPanelItemStateTransformer::class)]
final class StepperForPanelItemStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            StepperForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value',
            StepperForPanelItemStateTransformerInterface::KEY_UNIT => 'test-unit',
            StepperForPanelItemStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            StepperForPanelItemStateTransformerInterface::KEY_LABEL => 'test-label',
            StepperForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new StepperForPanelItemStateTransformer($alternativeItemTransformer);

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
        $transformer = new StepperForPanelItemStateTransformer($alternativeItemTransformer);
        $base = [StepperForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StepperForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StepperForPanelItemStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new StepperForPanelItemStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[StepperForPanelItemStateTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StepperForPanelItemStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([StepperForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[StepperForPanelItemStateTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[StepperForPanelItemStateTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[StepperForPanelItemStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[StepperForPanelItemStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[StepperForPanelItemStateTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[StepperForPanelItemStateTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StepperForPanelItemStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([StepperForPanelItemStateTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getUnit());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getAlternatives());
    }
}
