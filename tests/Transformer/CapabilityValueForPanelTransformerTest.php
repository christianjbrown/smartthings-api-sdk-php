<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValueForPanel;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForPanelTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForPanelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityValueForPanel::class)]
#[CoversClass(CapabilityValueForPanelTransformer::class)]
final class CapabilityValueForPanelTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            CapabilityValueForPanelTransformerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2'],
            CapabilityValueForPanelTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityValueForPanelTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            CapabilityValueForPanelTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            CapabilityValueForPanelTransformerInterface::KEY_STEP => 1.5,
            CapabilityValueForPanelTransformerInterface::KEY_KEY => 'test-key',
        ];

        $transformer = new CapabilityValueForPanelTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-enabled-values-1', 'test-enabled-values-2'], $actual->getEnabledValues());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-key', $actual->getKey());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new CapabilityValueForPanelTransformer($alternativeItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [CapabilityValueForPanelTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [CapabilityValueForPanelTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityValueForPanelTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'enabledValuesAbsent' => [[], 'getEnabledValues', null];
        yield 'enabledValuesWrongType' => [[CapabilityValueForPanelTransformerInterface::KEY_ENABLED_VALUES => 'not-array'], 'getEnabledValues', null];
        yield 'enabledValuesValid' => [[CapabilityValueForPanelTransformerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2']], 'getEnabledValues', ['test-enabled-values-1', 'test-enabled-values-2']];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityValueForPanelTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[CapabilityValueForPanelTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[CapabilityValueForPanelTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[CapabilityValueForPanelTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[CapabilityValueForPanelTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[CapabilityValueForPanelTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'keyAbsent' => [[], 'getKey', null];
        yield 'keyWrongType' => [[CapabilityValueForPanelTransformerInterface::KEY_KEY => 42], 'getKey', null];
        yield 'keyValid' => [[CapabilityValueForPanelTransformerInterface::KEY_KEY => 'test-key'], 'getKey', 'test-key'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new CapabilityValueForPanelTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getEnabledValues());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getStep());
        self::assertNull($actual->getKey());
    }
}
