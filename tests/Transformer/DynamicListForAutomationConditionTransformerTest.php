<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationCondition;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationConditionTransformer;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SupportedValuesForDynamicListTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DynamicListForAutomationCondition::class)]
#[CoversClass(DynamicListForAutomationConditionTransformer::class)]
final class DynamicListForAutomationConditionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListTransformer = self::createStub(SupportedValuesForDynamicListTransformerInterface::class);
        $supportedValuesForDynamicListTransformer->method('transform')->willReturn($supportedValuesForDynamicListModel);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value',
            DynamicListForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested'],
            DynamicListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            DynamicListForAutomationConditionTransformerInterface::KEY_MULTI_SELECTABLE => true,
        ];

        $transformer = new DynamicListForAutomationConditionTransformer($supportedValuesForDynamicListTransformer, $alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame($supportedValuesForDynamicListModel, $actual->getSupportedValues());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertTrue($actual->getMultiSelectable());
    }

    public function testTransformAlternatives(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListTransformer = self::createStub(SupportedValuesForDynamicListTransformerInterface::class);
        $supportedValuesForDynamicListTransformer->method('transform')->willReturn($supportedValuesForDynamicListModel);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new DynamicListForAutomationConditionTransformer($supportedValuesForDynamicListTransformer, $alternativeItemTransformer);
        $base = [DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [DynamicListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [DynamicListForAutomationConditionTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DynamicListForAutomationConditionTransformer(self::createStub(SupportedValuesForDynamicListTransformerInterface::class), self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[DynamicListForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[DynamicListForAutomationConditionTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'multiSelectableAbsent' => [[], 'getMultiSelectable', null];
        yield 'multiSelectableWrongType' => [[DynamicListForAutomationConditionTransformerInterface::KEY_MULTI_SELECTABLE => 'not-bool'], 'getMultiSelectable', null];
        yield 'multiSelectableValid' => [[DynamicListForAutomationConditionTransformerInterface::KEY_MULTI_SELECTABLE => true], 'getMultiSelectable', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListModel = self::createStub(SupportedValuesForDynamicListInterface::class);
        $supportedValuesForDynamicListTransformer = self::createStub(SupportedValuesForDynamicListTransformerInterface::class);
        $supportedValuesForDynamicListTransformer->method('transform')->willReturn($supportedValuesForDynamicListModel);
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new DynamicListForAutomationConditionTransformer($supportedValuesForDynamicListTransformer, $alternativeItemTransformer);

        $actual = $transformer->transform([DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']]);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getMultiSelectable());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DynamicListForAutomationConditionTransformer(self::createStub(SupportedValuesForDynamicListTransformerInterface::class), self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested']], sprintf(DynamicListForAutomationConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, DynamicListForAutomationConditionTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => ['test-nested'], DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 42], sprintf(DynamicListForAutomationConditionTransformerInterface::UNEXPECTED_STRING_SPRINTF, DynamicListForAutomationConditionTransformerInterface::KEY_VALUE)];
        yield 'supportedValuesAbsent' => [[DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value'], sprintf(DynamicListForAutomationConditionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES)];
        yield 'supportedValuesWrongType' => [[DynamicListForAutomationConditionTransformerInterface::KEY_VALUE => 'test-value', DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES => 'not-array'], sprintf(DynamicListForAutomationConditionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DynamicListForAutomationConditionTransformerInterface::KEY_SUPPORTED_VALUES)];
    }
}
