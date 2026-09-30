<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationCondition;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumSliderForAutomationCondition::class)]
#[CoversClass(EnumSliderForAutomationConditionTransformer::class)]
final class EnumSliderForAutomationConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $enumSliderForAutomationConditionSupportedOperatorsItemModel = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemTransformer = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemTransformer->method('transform')->willReturn($enumSliderForAutomationConditionSupportedOperatorsItemModel);
        $data = [
            EnumSliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            EnumSliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value',
            EnumSliderForAutomationConditionTransformerInterface::KEY_SUPPORTED_OPERATORS => [['test-nested']],
        ];

        $transformer = new EnumSliderForAutomationConditionTransformer($alternativeItemTransformer, $enumSliderForAutomationConditionSupportedOperatorsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame([$enumSliderForAutomationConditionSupportedOperatorsItemModel], $actual->getSupportedOperators());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new EnumSliderForAutomationConditionTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'alternativesAbsent' => [[EnumSliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'], 'getAlternatives', []];
        yield 'alternativesWrongType' => [[EnumSliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', EnumSliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => 'not-array'], 'getAlternatives', []];
        yield 'valueAbsent' => [[EnumSliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested']], 'getValue', null];
        yield 'valueWrongType' => [[EnumSliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], EnumSliderForAutomationConditionTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $enumSliderForAutomationConditionSupportedOperatorsItemModel = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemTransformer = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemTransformer->method('transform')->willReturn($enumSliderForAutomationConditionSupportedOperatorsItemModel);
        $transformer = new EnumSliderForAutomationConditionTransformer($alternativeItemTransformer, $enumSliderForAutomationConditionSupportedOperatorsItemTransformer);

        $actual = $transformer->transform([EnumSliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], EnumSliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getSupportedOperators());
    }

    public function testTransformSupportedOperators(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $enumSliderForAutomationConditionSupportedOperatorsItemModel = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemTransformer = self::createStub(EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface::class);
        $enumSliderForAutomationConditionSupportedOperatorsItemTransformer->method('transform')->willReturn($enumSliderForAutomationConditionSupportedOperatorsItemModel);
        $transformer = new EnumSliderForAutomationConditionTransformer($alternativeItemTransformer, $enumSliderForAutomationConditionSupportedOperatorsItemTransformer);
        $base = [EnumSliderForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => ['test-nested'], EnumSliderForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'];

        self::assertNull($transformer->transform($base)->getSupportedOperators());
        self::assertNull($transformer->transform($base + [EnumSliderForAutomationConditionTransformerInterface::KEY_SUPPORTED_OPERATORS => 'test-not-array'])->getSupportedOperators());
        self::assertSame([$enumSliderForAutomationConditionSupportedOperatorsItemModel], $transformer->transform($base + [EnumSliderForAutomationConditionTransformerInterface::KEY_SUPPORTED_OPERATORS => [['test-nested'], 'test-skipped']])->getSupportedOperators());
    }
}
