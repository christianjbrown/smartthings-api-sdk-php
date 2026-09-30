<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DetailViewListItem;
use ChristianBrown\SmartThings\Model\ListForDetailViewInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;
use ChristianBrown\SmartThings\Model\NumberFieldInterface;
use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PushButtonInterface;
use ChristianBrown\SmartThings\Model\SliderTypeInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchInterface;
use ChristianBrown\SmartThings\Model\StateInterface;
use ChristianBrown\SmartThings\Model\StepperInterface;
use ChristianBrown\SmartThings\Model\SwitchControlInterface;
use ChristianBrown\SmartThings\Model\TextButtonInterface;
use ChristianBrown\SmartThings\Model\TextFieldInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailViewInterface;
use ChristianBrown\SmartThings\Transformer\DetailViewListItemTransformer;
use ChristianBrown\SmartThings\Transformer\DetailViewListItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForDetailViewTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MultiArgCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NumberFieldTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PushButtonTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SliderTypeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StandbyPowerSwitchTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StepperTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SwitchControlTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextButtonTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TextFieldTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ToggleSwitchTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForDetailViewTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DetailViewListItem::class)]
#[CoversClass(DetailViewListItemTransformer::class)]
final class DetailViewListItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $data = [
            DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            DetailViewListItemTransformerInterface::KEY_VERSION => 7,
            DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label',
            DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            DetailViewListItemTransformerInterface::KEY_TOGGLE_SWITCH => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_SWITCH => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_SLIDER => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_TEXT_BUTTON => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_PLAY_PAUSE => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_PLAY_STOP => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_LIST => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_STEPPER => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_STATE => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_MULTI_ARG_COMMAND => ['test-nested'],
            DetailViewListItemTransformerInterface::KEY_COMPONENT => 'test-component',
            DetailViewListItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-display-type', $actual->getDisplayType());
        self::assertSame($toggleSwitchModel, $actual->getToggleSwitch());
        self::assertSame($standbyPowerSwitchModel, $actual->getStandbyPowerSwitch());
        self::assertSame($switchControlModel, $actual->getSwitch());
        self::assertSame($sliderTypeModel, $actual->getSlider());
        self::assertSame($pushButtonModel, $actual->getPushButton());
        self::assertSame($textButtonModel, $actual->getTextButton());
        self::assertSame($playPauseModel, $actual->getPlayPause());
        self::assertSame($playStopModel, $actual->getPlayStop());
        self::assertSame($listForDetailViewModel, $actual->getList());
        self::assertSame($textFieldModel, $actual->getTextField());
        self::assertSame($numberFieldModel, $actual->getNumberField());
        self::assertSame($stepperModel, $actual->getStepper());
        self::assertSame($stateModel, $actual->getState());
        self::assertSame($multiArgCommandModel, $actual->getMultiArgCommand());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame($visibleConditionForDetailViewModel, $actual->getVisibleCondition());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DetailViewListItemTransformer(self::createStub(ToggleSwitchTransformerInterface::class), self::createStub(StandbyPowerSwitchTransformerInterface::class), self::createStub(SwitchControlTransformerInterface::class), self::createStub(SliderTypeTransformerInterface::class), self::createStub(PushButtonTransformerInterface::class), self::createStub(TextButtonTransformerInterface::class), self::createStub(PlayPauseTransformerInterface::class), self::createStub(PlayStopTransformerInterface::class), self::createStub(ListForDetailViewTransformerInterface::class), self::createStub(TextFieldTransformerInterface::class), self::createStub(NumberFieldTransformerInterface::class), self::createStub(StepperTransformerInterface::class), self::createStub(StateTransformerInterface::class), self::createStub(MultiArgCommandTransformerInterface::class), self::createStub(VisibleConditionForDetailViewTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityAbsent' => [[DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getCapability', null];
        yield 'capabilityWrongType' => [[DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', DetailViewListItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'labelAbsent' => [[DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'], 'getLabel', null];
        yield 'labelWrongType' => [[DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type', DetailViewListItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'displayTypeAbsent' => [[DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label'], 'getDisplayType', null];
        yield 'displayTypeWrongType' => [[DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 42], 'getDisplayType', null];
    }

    public function testTransformList(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getList());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_LIST => 'test-not-array'])->getList());
        self::assertSame($listForDetailViewModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_LIST => ['test-nested']])->getList());
    }

    public function testTransformMultiArgCommand(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getMultiArgCommand());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_MULTI_ARG_COMMAND => 'test-not-array'])->getMultiArgCommand());
        self::assertSame($multiArgCommandModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_MULTI_ARG_COMMAND => ['test-nested']])->getMultiArgCommand());
    }

    public function testTransformNumberField(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getNumberField());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_NUMBER_FIELD => 'test-not-array'])->getNumberField());
        self::assertSame($numberFieldModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_NUMBER_FIELD => ['test-nested']])->getNumberField());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DetailViewListItemTransformer(self::createStub(ToggleSwitchTransformerInterface::class), self::createStub(StandbyPowerSwitchTransformerInterface::class), self::createStub(SwitchControlTransformerInterface::class), self::createStub(SliderTypeTransformerInterface::class), self::createStub(PushButtonTransformerInterface::class), self::createStub(TextButtonTransformerInterface::class), self::createStub(PlayPauseTransformerInterface::class), self::createStub(PlayStopTransformerInterface::class), self::createStub(ListForDetailViewTransformerInterface::class), self::createStub(TextFieldTransformerInterface::class), self::createStub(NumberFieldTransformerInterface::class), self::createStub(StepperTransformerInterface::class), self::createStub(StateTransformerInterface::class), self::createStub(MultiArgCommandTransformerInterface::class), self::createStub(VisibleConditionForDetailViewTransformerInterface::class));

        $actual = $transformer->transform([DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DetailViewListItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[DetailViewListItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'componentAbsent' => [[], 'getComponent', null];
        yield 'componentWrongType' => [[DetailViewListItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'componentValid' => [[DetailViewListItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getComponent', 'test-component'];
    }

    public function testTransformPlayPause(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPlayPause());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_PLAY_PAUSE => 'test-not-array'])->getPlayPause());
        self::assertSame($playPauseModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_PLAY_PAUSE => ['test-nested']])->getPlayPause());
    }

    public function testTransformPlayStop(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPlayStop());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_PLAY_STOP => 'test-not-array'])->getPlayStop());
        self::assertSame($playStopModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_PLAY_STOP => ['test-nested']])->getPlayStop());
    }

    public function testTransformPushButton(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getPushButton());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_PUSH_BUTTON => 'test-not-array'])->getPushButton());
        self::assertSame($pushButtonModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_PUSH_BUTTON => ['test-nested']])->getPushButton());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);

        $actual = $transformer->transform([DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getToggleSwitch());
        self::assertNull($actual->getStandbyPowerSwitch());
        self::assertNull($actual->getSwitch());
        self::assertNull($actual->getSlider());
        self::assertNull($actual->getPushButton());
        self::assertNull($actual->getTextButton());
        self::assertNull($actual->getPlayPause());
        self::assertNull($actual->getPlayStop());
        self::assertNull($actual->getList());
        self::assertNull($actual->getTextField());
        self::assertNull($actual->getNumberField());
        self::assertNull($actual->getStepper());
        self::assertNull($actual->getState());
        self::assertNull($actual->getMultiArgCommand());
        self::assertNull($actual->getComponent());
        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformSlider(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSlider());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_SLIDER => 'test-not-array'])->getSlider());
        self::assertSame($sliderTypeModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_SLIDER => ['test-nested']])->getSlider());
    }

    public function testTransformStandbyPowerSwitch(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStandbyPowerSwitch());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => 'test-not-array'])->getStandbyPowerSwitch());
        self::assertSame($standbyPowerSwitchModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_STANDBY_POWER_SWITCH => ['test-nested']])->getStandbyPowerSwitch());
    }

    public function testTransformState(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($stateModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    public function testTransformStepper(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getStepper());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_STEPPER => 'test-not-array'])->getStepper());
        self::assertSame($stepperModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_STEPPER => ['test-nested']])->getStepper());
    }

    public function testTransformSwitch(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getSwitch());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_SWITCH => 'test-not-array'])->getSwitch());
        self::assertSame($switchControlModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_SWITCH => ['test-nested']])->getSwitch());
    }

    public function testTransformTextButton(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextButton());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_TEXT_BUTTON => 'test-not-array'])->getTextButton());
        self::assertSame($textButtonModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_TEXT_BUTTON => ['test-nested']])->getTextButton());
    }

    public function testTransformTextField(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getTextField());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_TEXT_FIELD => 'test-not-array'])->getTextField());
        self::assertSame($textFieldModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_TEXT_FIELD => ['test-nested']])->getTextField());
    }

    public function testTransformToggleSwitch(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getToggleSwitch());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_TOGGLE_SWITCH => 'test-not-array'])->getToggleSwitch());
        self::assertSame($toggleSwitchModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_TOGGLE_SWITCH => ['test-nested']])->getToggleSwitch());
    }

    public function testTransformVisibleCondition(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchTransformer = self::createStub(ToggleSwitchTransformerInterface::class);
        $toggleSwitchTransformer->method('transform')->willReturn($toggleSwitchModel);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchTransformer = self::createStub(StandbyPowerSwitchTransformerInterface::class);
        $standbyPowerSwitchTransformer->method('transform')->willReturn($standbyPowerSwitchModel);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlTransformer = self::createStub(SwitchControlTransformerInterface::class);
        $switchControlTransformer->method('transform')->willReturn($switchControlModel);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeTransformer = self::createStub(SliderTypeTransformerInterface::class);
        $sliderTypeTransformer->method('transform')->willReturn($sliderTypeModel);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonTransformer = self::createStub(PushButtonTransformerInterface::class);
        $pushButtonTransformer->method('transform')->willReturn($pushButtonModel);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonTransformer = self::createStub(TextButtonTransformerInterface::class);
        $textButtonTransformer->method('transform')->willReturn($textButtonModel);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseTransformer = self::createStub(PlayPauseTransformerInterface::class);
        $playPauseTransformer->method('transform')->willReturn($playPauseModel);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopTransformer = self::createStub(PlayStopTransformerInterface::class);
        $playStopTransformer->method('transform')->willReturn($playStopModel);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewTransformer = self::createStub(ListForDetailViewTransformerInterface::class);
        $listForDetailViewTransformer->method('transform')->willReturn($listForDetailViewModel);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldTransformer = self::createStub(TextFieldTransformerInterface::class);
        $textFieldTransformer->method('transform')->willReturn($textFieldModel);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldTransformer = self::createStub(NumberFieldTransformerInterface::class);
        $numberFieldTransformer->method('transform')->willReturn($numberFieldModel);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperTransformer = self::createStub(StepperTransformerInterface::class);
        $stepperTransformer->method('transform')->willReturn($stepperModel);
        $stateModel = self::createStub(StateInterface::class);
        $stateTransformer = self::createStub(StateTransformerInterface::class);
        $stateTransformer->method('transform')->willReturn($stateModel);
        $multiArgCommandModel = self::createStub(MultiArgCommandInterface::class);
        $multiArgCommandTransformer = self::createStub(MultiArgCommandTransformerInterface::class);
        $multiArgCommandTransformer->method('transform')->willReturn($multiArgCommandModel);
        $visibleConditionForDetailViewModel = self::createStub(VisibleConditionForDetailViewInterface::class);
        $visibleConditionForDetailViewTransformer = self::createStub(VisibleConditionForDetailViewTransformerInterface::class);
        $visibleConditionForDetailViewTransformer->method('transform')->willReturn($visibleConditionForDetailViewModel);
        $transformer = new DetailViewListItemTransformer($toggleSwitchTransformer, $standbyPowerSwitchTransformer, $switchControlTransformer, $sliderTypeTransformer, $pushButtonTransformer, $textButtonTransformer, $playPauseTransformer, $playStopTransformer, $listForDetailViewTransformer, $textFieldTransformer, $numberFieldTransformer, $stepperTransformer, $stateTransformer, $multiArgCommandTransformer, $visibleConditionForDetailViewTransformer);
        $base = [DetailViewListItemTransformerInterface::KEY_CAPABILITY => 'test-capability', DetailViewListItemTransformerInterface::KEY_LABEL => 'test-label', DetailViewListItemTransformerInterface::KEY_DISPLAY_TYPE => 'test-display-type'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionForDetailViewModel, $transformer->transform($base + [DetailViewListItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
