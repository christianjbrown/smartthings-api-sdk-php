<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AutomationListItem;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\AutomationListItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationListItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AutomationListItem::class)]
#[CoversClass(AutomationListItemTransformer::class)]
final class AutomationListItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            AutomationListItemTransformerInterface::KEY_VERSION => 7,
            AutomationListItemTransformerInterface::KEY_LABEL => 'test-label',
            AutomationListItemTransformerInterface::KEY_DESCRIPTION => 'test-description',
            AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            AutomationListItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            AutomationListItemTransformerInterface::KEY_LIST => ['test-nested'],
            AutomationListItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested'],
            AutomationListItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested'],
            AutomationListItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested'],
            AutomationListItemTransformerInterface::KEY_ENUM_SLIDER => ['test-nested'],
            AutomationListItemTransformerInterface::KEY_EMPHASIS => true,
            AutomationListItemTransformerInterface::KEY_EXCLUSION => [['test-nested']],
            AutomationListItemTransformerInterface::KEY_COMPONENT => 'test-component',
            AutomationListItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($sliderForAutomationConditionModel, $actual->getSlider());
        self::assertSame($listForAutomationConditionModel, $actual->getList());
        self::assertSame($dynamicListForAutomationConditionModel, $actual->getDynamicList());
        self::assertSame($numberFieldForAutomationConditionModel, $actual->getNumberField());
        self::assertSame($textFieldForAutomationConditionModel, $actual->getTextField());
        self::assertSame($enumSliderForAutomationConditionModel, $actual->getEnumSlider());
        self::assertTrue($actual->getEmphasis());
        self::assertSame([$excludedConditionItemModel], $actual->getExclusion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
    }

    public function testTransformDynamicList(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getDynamicList());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_DYNAMIC_LIST => 'test-not-array'])->getDynamicList());
        self::assertSame($dynamicListForAutomationConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested']])->getDynamicList());
    }

    public function testTransformEnumSlider(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getEnumSlider());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_ENUM_SLIDER => 'test-not-array'])->getEnumSlider());
        self::assertSame($enumSliderForAutomationConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_ENUM_SLIDER => ['test-nested']])->getEnumSlider());
    }

    public function testTransformExclusion(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getExclusion());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_EXCLUSION => 'test-not-array'])->getExclusion());
        self::assertSame([$excludedConditionItemModel], $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_EXCLUSION => [['test-nested'], 'test-skipped']])->getExclusion());
    }

    public function testTransformList(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForAutomationConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
    }

    public function testTransformNumberField(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getNumberField());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_NUMBER_FIELD => 'test-not-array'])->getNumberField());
        self::assertSame($numberFieldForAutomationConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested']])->getNumberField());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AutomationListItemTransformer(self::createStub(SliderForAutomationConditionTransformerInterface::class), self::createStub(ListForAutomationConditionTransformerInterface::class), self::createStub(DynamicListForAutomationConditionTransformerInterface::class), self::createStub(NumberFieldForAutomationConditionTransformerInterface::class), self::createStub(TextFieldForAutomationConditionTransformerInterface::class), self::createStub(EnumSliderForAutomationConditionTransformerInterface::class), self::createStub(ExcludedConditionItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[AutomationListItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[AutomationListItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[AutomationListItemTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[AutomationListItemTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'emphasisAbsent' => [[], 'getEmphasis', null];
        yield 'emphasisWrongType' => [[AutomationListItemTransformerInterface::KEY_EMPHASIS => 'not-bool'], 'getEmphasis', null];
        yield 'emphasisValid' => [[AutomationListItemTransformerInterface::KEY_EMPHASIS => true], 'getEmphasis', true];
        yield 'componentAbsent' => [[], 'getComponent', null];
        yield 'componentWrongType' => [[AutomationListItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'componentValid' => [[AutomationListItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getComponent', 'test-component'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getList());
        self::assertNull($actual->getDynamicList());
        self::assertNull($actual->getNumberField());
        self::assertNull($actual->getTextField());
        self::assertNull($actual->getEnumSlider());
        self::assertNull($actual->getEmphasis());
        self::assertNull($actual->getExclusion());
        self::assertNull($actual->getComponent());
        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformSlider(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderForAutomationConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
    }

    public function testTransformTextField(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextField());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_TEXT_FIELD => 'test-not-array'])->getTextField());
        self::assertSame($textFieldForAutomationConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested']])->getTextField());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new AutomationListItemTransformer(self::createStub(SliderForAutomationConditionTransformerInterface::class), self::createStub(ListForAutomationConditionTransformerInterface::class), self::createStub(DynamicListForAutomationConditionTransformerInterface::class), self::createStub(NumberFieldForAutomationConditionTransformerInterface::class), self::createStub(TextFieldForAutomationConditionTransformerInterface::class), self::createStub(EnumSliderForAutomationConditionTransformerInterface::class), self::createStub(ExcludedConditionItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], sprintf(AutomationListItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationListItemTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', AutomationListItemTransformerInterface::KEY_CAPABILITY => 42], sprintf(AutomationListItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationListItemTransformerInterface::KEY_CAPABILITY)];
        yield 'labelAbsent' => [[AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], sprintf(AutomationListItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationListItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', AutomationListItemTransformerInterface::KEY_LABEL => 42], sprintf(AutomationListItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationListItemTransformerInterface::KEY_LABEL)];
        yield 'displayTypeAbsent' => [[AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(AutomationListItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE)];
        yield 'displayTypeWrongType' => [[AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 42], sprintf(AutomationListItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE)];
    }

    public function testTransformVisibleCondition(): void
    {
        $sliderForAutomationConditionModel = self::createStub(SliderForAutomationConditionInterface::class);
        $sliderForAutomationConditionTransformer = self::createStub(SliderForAutomationConditionTransformerInterface::class);
        $sliderForAutomationConditionTransformer->method('transform')->willReturn($sliderForAutomationConditionModel);
        $listForAutomationConditionModel = self::createStub(ListForAutomationConditionInterface::class);
        $listForAutomationConditionTransformer = self::createStub(ListForAutomationConditionTransformerInterface::class);
        $listForAutomationConditionTransformer->method('transform')->willReturn($listForAutomationConditionModel);
        $dynamicListForAutomationConditionModel = self::createStub(DynamicListForAutomationConditionInterface::class);
        $dynamicListForAutomationConditionTransformer = self::createStub(DynamicListForAutomationConditionTransformerInterface::class);
        $dynamicListForAutomationConditionTransformer->method('transform')->willReturn($dynamicListForAutomationConditionModel);
        $numberFieldForAutomationConditionModel = self::createStub(NumberFieldForAutomationConditionInterface::class);
        $numberFieldForAutomationConditionTransformer = self::createStub(NumberFieldForAutomationConditionTransformerInterface::class);
        $numberFieldForAutomationConditionTransformer->method('transform')->willReturn($numberFieldForAutomationConditionModel);
        $textFieldForAutomationConditionModel = self::createStub(TextFieldForAutomationConditionInterface::class);
        $textFieldForAutomationConditionTransformer = self::createStub(TextFieldForAutomationConditionTransformerInterface::class);
        $textFieldForAutomationConditionTransformer->method('transform')->willReturn($textFieldForAutomationConditionModel);
        $enumSliderForAutomationConditionModel = self::createStub(EnumSliderForAutomationConditionInterface::class);
        $enumSliderForAutomationConditionTransformer = self::createStub(EnumSliderForAutomationConditionTransformerInterface::class);
        $enumSliderForAutomationConditionTransformer->method('transform')->willReturn($enumSliderForAutomationConditionModel);
        $excludedConditionItemModel = self::createStub(ExcludedConditionItemInterface::class);
        $excludedConditionItemTransformer = self::createStub(ExcludedConditionItemTransformerInterface::class);
        $excludedConditionItemTransformer->method('transform')->willReturn($excludedConditionItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new AutomationListItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $excludedConditionItemTransformer, $visibleConditionTransformer);
        $base = [AutomationListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', AutomationListItemTransformerInterface::KEY_LABEL => 'test-label', AutomationListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [AutomationListItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [AutomationListItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
