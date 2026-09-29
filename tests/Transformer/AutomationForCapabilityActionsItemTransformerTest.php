<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItem;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityActionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DynamicListForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextFieldForAutomationActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionBaseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AutomationForCapabilityActionsItem::class)]
#[CoversClass(AutomationForCapabilityActionsItemTransformer::class)]
final class AutomationForCapabilityActionsItemTransformerTest extends TestCase
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $data = [
            AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label',
            AutomationForCapabilityActionsItemTransformerInterface::KEY_DESCRIPTION => 'test-description',
            AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            AutomationForCapabilityActionsItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            AutomationForCapabilityActionsItemTransformerInterface::KEY_LIST => ['test-nested'],
            AutomationForCapabilityActionsItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested'],
            AutomationForCapabilityActionsItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested'],
            AutomationForCapabilityActionsItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested'],
            AutomationForCapabilityActionsItemTransformerInterface::KEY_MULTI_ARG_COMMAND => ['test-nested'],
            AutomationForCapabilityActionsItemTransformerInterface::KEY_EMPHASIS => true,
            AutomationForCapabilityActionsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);

        $actual = $transformer->transform($data);

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
        self::assertSame($visibleConditionBaseModel, $actual->getVisibleCondition());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getDynamicList());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_DYNAMIC_LIST => 'test-not-array'])->getDynamicList());
        self::assertSame($dynamicListForAutomationActionModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_DYNAMIC_LIST => ['test-nested']])->getDynamicList());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForAutomationActionModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getMultiArgCommand());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_MULTI_ARG_COMMAND => 'test-not-array'])->getMultiArgCommand());
        self::assertSame($multiArgCommandModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_MULTI_ARG_COMMAND => ['test-nested']])->getMultiArgCommand());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getNumberField());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_NUMBER_FIELD => 'test-not-array'])->getNumberField());
        self::assertSame($numberFieldForAutomationActionModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested']])->getNumberField());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AutomationForCapabilityActionsItemTransformer(self::createStub(SliderForAutomationActionTransformerInterface::class), self::createStub(ListForAutomationActionTransformerInterface::class), self::createStub(DynamicListForAutomationActionTransformerInterface::class), self::createStub(TextFieldForAutomationActionTransformerInterface::class), self::createStub(NumberFieldForAutomationActionTransformerInterface::class), self::createStub(MultiArgCommandTransformerInterface::class), self::createStub(VisibleConditionBaseTransformerInterface::class));

        $actual = $transformer->transform([AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'emphasisAbsent' => [[], 'getEmphasis', null];
        yield 'emphasisWrongType' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_EMPHASIS => 'not-bool'], 'getEmphasis', null];
        yield 'emphasisValid' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_EMPHASIS => true], 'getEmphasis', true];
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);

        $actual = $transformer->transform([AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getDescription());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getList());
        self::assertNull($actual->getDynamicList());
        self::assertNull($actual->getTextField());
        self::assertNull($actual->getNumberField());
        self::assertNull($actual->getMultiArgCommand());
        self::assertNull($actual->getEmphasis());
        self::assertNull($actual->getVisibleCondition());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderForAutomationActionModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextField());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_TEXT_FIELD => 'test-not-array'])->getTextField());
        self::assertSame($textFieldForAutomationActionModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested']])->getTextField());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new AutomationForCapabilityActionsItemTransformer(self::createStub(SliderForAutomationActionTransformerInterface::class), self::createStub(ListForAutomationActionTransformerInterface::class), self::createStub(DynamicListForAutomationActionTransformerInterface::class), self::createStub(TextFieldForAutomationActionTransformerInterface::class), self::createStub(NumberFieldForAutomationActionTransformerInterface::class), self::createStub(MultiArgCommandTransformerInterface::class), self::createStub(VisibleConditionBaseTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], sprintf(AutomationForCapabilityActionsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 42], sprintf(AutomationForCapabilityActionsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL)];
        yield 'displayTypeAbsent' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(AutomationForCapabilityActionsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE)];
        yield 'displayTypeWrongType' => [[AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 42], sprintf(AutomationForCapabilityActionsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE)];
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
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseTransformer = self::createStub(VisibleConditionBaseTransformerInterface::class);
        $visibleConditionBaseTransformer->method('transform')->willReturn($visibleConditionBaseModel);
        $transformer = new AutomationForCapabilityActionsItemTransformer($sliderForAutomationActionTransformer, $listForAutomationActionTransformer, $dynamicListForAutomationActionTransformer, $textFieldForAutomationActionTransformer, $numberFieldForAutomationActionTransformer, $multiArgCommandTransformer, $visibleConditionBaseTransformer);
        $base = [AutomationForCapabilityActionsItemTransformerInterface::KEY_LABEL => 'test-label', AutomationForCapabilityActionsItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionBaseModel, $transformer->transform($base + [AutomationForCapabilityActionsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
