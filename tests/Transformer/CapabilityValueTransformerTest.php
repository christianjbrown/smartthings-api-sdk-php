<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValue;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityValue::class)]
#[CoversClass(CapabilityValueTransformer::class)]
final class CapabilityValueTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            CapabilityValueTransformerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2'],
            CapabilityValueTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityValueTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            CapabilityValueTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            CapabilityValueTransformerInterface::KEY_STEP => 1.5,
            CapabilityValueTransformerInterface::KEY_KEY => 'test-key',
        ];

        $transformer = new CapabilityValueTransformer($alternativeItemTransformer);

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
        $transformer = new CapabilityValueTransformer($alternativeItemTransformer);
        $base = [CapabilityValueTransformerInterface::KEY_KEY => 'test-key'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [CapabilityValueTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [CapabilityValueTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityValueTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'keyAbsent' => [[], 'getKey', null];
        yield 'keyWrongType' => [[CapabilityValueTransformerInterface::KEY_KEY => 42], 'getKey', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityValueTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([CapabilityValueTransformerInterface::KEY_KEY => 'test-key'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'enabledValuesAbsent' => [[], 'getEnabledValues', null];
        yield 'enabledValuesWrongType' => [[CapabilityValueTransformerInterface::KEY_ENABLED_VALUES => 'not-array'], 'getEnabledValues', null];
        yield 'enabledValuesValid' => [[CapabilityValueTransformerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2']], 'getEnabledValues', ['test-enabled-values-1', 'test-enabled-values-2']];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityValueTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[CapabilityValueTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[CapabilityValueTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[CapabilityValueTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[CapabilityValueTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[CapabilityValueTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new CapabilityValueTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([CapabilityValueTransformerInterface::KEY_KEY => 'test-key']);

        self::assertNull($actual->getEnabledValues());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getStep());
    }
}
