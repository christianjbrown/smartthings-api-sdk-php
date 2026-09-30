<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionListItem;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\ActionListItemTransformer;
use ChristianBrown\SmartThings\Transformer\ActionListItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ActionListItem::class)]
#[CoversClass(ActionListItemTransformer::class)]
final class ActionListItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $data = [
            ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ActionListItemTransformerInterface::KEY_VERSION => 7,
            ActionListItemTransformerInterface::KEY_LABEL => 'test-label',
            ActionListItemTransformerInterface::KEY_DESCRIPTION => 'test-description',
            ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ActionListItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            ActionListItemTransformerInterface::KEY_LIST => ['test-nested'],
            ActionListItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested'],
            ActionListItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested'],
            ActionListItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested'],
            ActionListItemTransformerInterface::KEY_MULTI_ARG_COMMAND => ['test-nested'],
            ActionListItemTransformerInterface::KEY_EMPHASIS => true,
            ActionListItemTransformerInterface::KEY_COMPONENT => 'test-component',
            ActionListItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
            ActionListItemTransformerInterface::KEY_EXCLUSION => [['test-nested']],
        ];

        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($sliderForAutomationActionModel, $actual->getSlider());
        self::assertSame($listForAutomationActionModel, $actual->getList());
        self::assertSame($dynamicListForAutomationActionModel, $actual->getDynamicList());
        self::assertSame($textFieldForAutomationActionModel, $actual->getTextField());
        self::assertSame($numberFieldForAutomationActionModel, $actual->getNumberField());
        self::assertSame($multiArgCommandModel, $actual->getMultiArgCommand());
        self::assertTrue($actual->getEmphasis());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
        self::assertSame([$excludedActionItemModel], $actual->getExclusion());
    }

    public function testTransformDynamicList(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getDynamicList());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_DYNAMIC_LIST => 'test-not-array'])->getDynamicList());
        self::assertSame($dynamicListForAutomationActionModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested']])->getDynamicList());
    }

    public function testTransformExclusion(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getExclusion());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_EXCLUSION => 'test-not-array'])->getExclusion());
        self::assertSame([$excludedActionItemModel], $transformer->transform($base + [ActionListItemTransformerInterface::KEY_EXCLUSION => [['test-nested'], 'test-skipped']])->getExclusion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ActionListItemTransformer(self::createStub(SliderForAutomationActionTransformerInterface::class), self::createStub(ListForAutomationActionTransformerInterface::class), self::createStub(DynamicListForAutomationActionTransformerInterface::class), self::createStub(TextFieldForAutomationActionTransformerInterface::class), self::createStub(NumberFieldForAutomationActionTransformerInterface::class), self::createStub(MultiArgCommandTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class), self::createStub(ExcludedActionItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityAbsent' => [[ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getCapability', null];
        yield 'capabilityWrongType' => [[ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionListItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'labelAbsent' => [[ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getLabel', null];
        yield 'labelWrongType' => [[ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', ActionListItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'displayTypeAbsent' => [[ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label'], 'getDisplayType', null];
        yield 'displayTypeWrongType' => [[ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 42], 'getDisplayType', null];
    }

    public function testTransformList(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForAutomationActionModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
    }

    public function testTransformMultiArgCommand(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getMultiArgCommand());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_MULTI_ARG_COMMAND => 'test-not-array'])->getMultiArgCommand());
        self::assertSame($multiArgCommandModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_MULTI_ARG_COMMAND => ['test-nested']])->getMultiArgCommand());
    }

    public function testTransformNumberField(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getNumberField());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_NUMBER_FIELD => 'test-not-array'])->getNumberField());
        self::assertSame($numberFieldForAutomationActionModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested']])->getNumberField());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ActionListItemTransformer(self::createStub(SliderForAutomationActionTransformerInterface::class), self::createStub(ListForAutomationActionTransformerInterface::class), self::createStub(DynamicListForAutomationActionTransformerInterface::class), self::createStub(TextFieldForAutomationActionTransformerInterface::class), self::createStub(NumberFieldForAutomationActionTransformerInterface::class), self::createStub(MultiArgCommandTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class), self::createStub(ExcludedActionItemTransformerInterface::class));

        $actual = $transformer->transform([ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ActionListItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ActionListItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[ActionListItemTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[ActionListItemTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'emphasisAbsent' => [[], 'getEmphasis', null];
        yield 'emphasisWrongType' => [[ActionListItemTransformerInterface::KEY_EMPHASIS => 'not-bool'], 'getEmphasis', null];
        yield 'emphasisValid' => [[ActionListItemTransformerInterface::KEY_EMPHASIS => true], 'getEmphasis', true];
        yield 'componentAbsent' => [[], 'getComponent', null];
        yield 'componentWrongType' => [[ActionListItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'componentValid' => [[ActionListItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getComponent', 'test-component'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);

        $actual = $transformer->transform([ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getList());
        self::assertNull($actual->getDynamicList());
        self::assertNull($actual->getTextField());
        self::assertNull($actual->getNumberField());
        self::assertNull($actual->getMultiArgCommand());
        self::assertNull($actual->getEmphasis());
        self::assertNull($actual->getComponent());
        self::assertNull($actual->getVisibleCondition());
        self::assertNull($actual->getExclusion());
    }

    public function testTransformSlider(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderForAutomationActionModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
    }

    public function testTransformTextField(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextField());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_TEXT_FIELD => 'test-not-array'])->getTextField());
        self::assertSame($textFieldForAutomationActionModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested']])->getTextField());
    }

    public function testTransformVisibleCondition(): void
    {
        $sliderForAutomationActionModel = self::createStub(SliderForAutomationActionInterface::class);
        $sliderForAutomationActionTransformer = self::createStub(SliderForAutomationActionTransformerInterface::class);
        $sliderForAutomationActionTransformer->method('transform')->willReturn($sliderForAutomationActionModel);
        $listForAutomationActionModel = self::createStub(ListForAutomationActionInterface::class);
        $listForAutomationActionTransformer = self::createStub(ListForAutomationActionTransformerInterface::class);
        $listForAutomationActionTransformer->method('transform')->willReturn($listForAutomationActionModel);
        $dynamicListForAutomationActionModel = self::createStub(DynamicListForAutomationActionInterface::class);
        $dynamicListForAutomationActionTransformer = self::createStub(DynamicListForAutomationActionTransformerInterface::class);
        $dynamicListForAutomationActionTransformer->method('transform')->willReturn($dynamicListForAutomationActionModel);
        $textFieldForAutomationActionModel = self::createStub(TextFieldForAutomationActionInterface::class);
        $textFieldForAutomationActionTransformer = self::createStub(TextFieldForAutomationActionTransformerInterface::class);
        $textFieldForAutomationActionTransformer->method('transform')->willReturn($textFieldForAutomationActionModel);
        $numberFieldForAutomationActionModel = self::createStub(NumberFieldForAutomationActionInterface::class);
        $numberFieldForAutomationActionTransformer = self::createStub(NumberFieldForAutomationActionTransformerInterface::class);
        $numberFieldForAutomationActionTransformer->method('transform')->willReturn($numberFieldForAutomationActionModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $excludedActionItemModel = self::createStub(ExcludedActionItemInterface::class);
        $excludedActionItemTransformer = self::createStub(ExcludedActionItemTransformerInterface::class);
        $excludedActionItemTransformer->method('transform')->willReturn($excludedActionItemModel);
        $transformer = new ActionListItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionTransformer, $excludedActionItemTransformer);
        $base = [ActionListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', ActionListItemTransformerInterface::KEY_LABEL => 'test-label', ActionListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [ActionListItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [ActionListItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
