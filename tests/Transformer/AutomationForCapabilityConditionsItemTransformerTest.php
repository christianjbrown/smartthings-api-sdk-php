<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItem;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityConditionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityConditionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EnumSliderForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationConditionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutomationForCapabilityConditionsItem::class)]
#[CoversClass(AutomationForCapabilityConditionsItemTransformer::class)]
final class AutomationForCapabilityConditionsItemTransformerTest extends TestCase
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $data = [
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label',
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_DESCRIPTION => 'test-description',
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_LIST => ['test-nested'],
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested'],
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested'],
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested'],
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_ENUM_SLIDER => ['test-nested'],
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_EMPHASIS => true,
            AutomationForCapabilityConditionsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);

        $actual = $transformer->transform($data);

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
        self::assertSame($visibleConditionBaseModel, $actual->getVisibleCondition());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getDynamicList());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_DYNAMIC_LIST => 'test-not-array'])->getDynamicList());
        self::assertSame($dynamicListForAutomationConditionModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested']])->getDynamicList());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getEnumSlider());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_ENUM_SLIDER => 'test-not-array'])->getEnumSlider());
        self::assertSame($enumSliderForAutomationConditionModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_ENUM_SLIDER => ['test-nested']])->getEnumSlider());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new AutomationForCapabilityConditionsItemTransformer(self::createStub(SliderForAutomationConditionTransformerInterface::class), self::createStub(ListForAutomationConditionTransformerInterface::class), self::createStub(DynamicListForAutomationConditionTransformerInterface::class), self::createStub(NumberFieldForAutomationConditionTransformerInterface::class), self::createStub(TextFieldForAutomationConditionTransformerInterface::class), self::createStub(EnumSliderForAutomationConditionTransformerInterface::class), self::createStub(VisibleConditionBaseTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getLabel', null];
        yield 'labelWrongType' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'displayTypeAbsent' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label'], 'getDisplayType', null];
        yield 'displayTypeWrongType' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 42], 'getDisplayType', null];
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForAutomationConditionModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getNumberField());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_NUMBER_FIELD => 'test-not-array'])->getNumberField());
        self::assertSame($numberFieldForAutomationConditionModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested']])->getNumberField());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AutomationForCapabilityConditionsItemTransformer(self::createStub(SliderForAutomationConditionTransformerInterface::class), self::createStub(ListForAutomationConditionTransformerInterface::class), self::createStub(DynamicListForAutomationConditionTransformerInterface::class), self::createStub(NumberFieldForAutomationConditionTransformerInterface::class), self::createStub(TextFieldForAutomationConditionTransformerInterface::class), self::createStub(EnumSliderForAutomationConditionTransformerInterface::class), self::createStub(VisibleConditionBaseTransformerInterface::class));

        $actual = $transformer->transform([AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'emphasisAbsent' => [[], 'getEmphasis', null];
        yield 'emphasisWrongType' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_EMPHASIS => 'not-bool'], 'getEmphasis', null];
        yield 'emphasisValid' => [[AutomationForCapabilityConditionsItemTransformerInterface::KEY_EMPHASIS => true], 'getEmphasis', true];
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);

        $actual = $transformer->transform([AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getDescription());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getList());
        self::assertNull($actual->getDynamicList());
        self::assertNull($actual->getNumberField());
        self::assertNull($actual->getTextField());
        self::assertNull($actual->getEnumSlider());
        self::assertNull($actual->getEmphasis());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderForAutomationConditionModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextField());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_TEXT_FIELD => 'test-not-array'])->getTextField());
        self::assertSame($textFieldForAutomationConditionModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested']])->getTextField());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityConditionsItemTransformer($sliderForAutomationConditionTransformer, $listForAutomationConditionTransformer, $dynamicListForAutomationConditionTransformer, $numberFieldForAutomationConditionTransformer, $textFieldForAutomationConditionTransformer, $enumSliderForAutomationConditionTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityConditionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityConditionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionBaseModel, $transformer->transform($base + [AutomationForCapabilityConditionsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
