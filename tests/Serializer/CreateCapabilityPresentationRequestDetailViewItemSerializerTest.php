<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItem;
use ChristianBrown\SmartThings\Model\ListForDetailViewInterface;
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
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListForDetailViewSerializerInterface;
use ChristianBrown\SmartThings\Serializer\NumberFieldSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayPauseSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PlayStopSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PushButtonSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SliderTypeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StandbyPowerSwitchSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StateSerializerInterface;
use ChristianBrown\SmartThings\Serializer\StepperSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SwitchControlSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TextButtonSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TextFieldSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ToggleSwitchSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateCapabilityPresentationRequestDetailViewItem::class)]
#[CoversClass(CreateCapabilityPresentationRequestDetailViewItemSerializer::class)]
final class CreateCapabilityPresentationRequestDetailViewItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchSerializer = self::createStub(ToggleSwitchSerializerInterface::class);
        $toggleSwitchSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch']);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchSerializer = self::createStub(StandbyPowerSwitchSerializerInterface::class);
        $standbyPowerSwitchSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch']);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlSerializer = self::createStub(SwitchControlSerializerInterface::class);
        $switchControlSerializer->method('serialize')->willReturn(['test-serialized-switch-control']);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeSerializer = self::createStub(SliderTypeSerializerInterface::class);
        $sliderTypeSerializer->method('serialize')->willReturn(['test-serialized-slider-type']);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonSerializer = self::createStub(PushButtonSerializerInterface::class);
        $pushButtonSerializer->method('serialize')->willReturn(['test-serialized-push-button']);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonSerializer = self::createStub(TextButtonSerializerInterface::class);
        $textButtonSerializer->method('serialize')->willReturn(['test-serialized-text-button']);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseSerializer = self::createStub(PlayPauseSerializerInterface::class);
        $playPauseSerializer->method('serialize')->willReturn(['test-serialized-play-pause']);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopSerializer = self::createStub(PlayStopSerializerInterface::class);
        $playStopSerializer->method('serialize')->willReturn(['test-serialized-play-stop']);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewSerializer = self::createStub(ListForDetailViewSerializerInterface::class);
        $listForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-list-for-detail-view']);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldSerializer = self::createStub(TextFieldSerializerInterface::class);
        $textFieldSerializer->method('serialize')->willReturn(['test-serialized-text-field']);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldSerializer = self::createStub(NumberFieldSerializerInterface::class);
        $numberFieldSerializer->method('serialize')->willReturn(['test-serialized-number-field']);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperSerializer = self::createStub(StepperSerializerInterface::class);
        $stepperSerializer->method('serialize')->willReturn(['test-serialized-stepper']);
        $stateModel = self::createStub(StateInterface::class);
        $stateSerializer = self::createStub(StateSerializerInterface::class);
        $stateSerializer->method('serialize')->willReturn(['test-serialized-state']);
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseSerializer = self::createStub(VisibleConditionBaseSerializerInterface::class);
        $visibleConditionBaseSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-base']);
        $model = new CreateCapabilityPresentationRequestDetailViewItem('test-label', 'test-display-type');

        $serializer = new CreateCapabilityPresentationRequestDetailViewItemSerializer($toggleSwitchSerializer, $standbyPowerSwitchSerializer, $switchControlSerializer, $sliderTypeSerializer, $pushButtonSerializer, $textButtonSerializer, $playPauseSerializer, $playStopSerializer, $listForDetailViewSerializer, $textFieldSerializer, $numberFieldSerializer, $stepperSerializer, $stateSerializer, $visibleConditionBaseSerializer);

        self::assertSame(
            [
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_LABEL => 'test-label',
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $toggleSwitchModel = self::createStub(ToggleSwitchInterface::class);
        $toggleSwitchSerializer = self::createStub(ToggleSwitchSerializerInterface::class);
        $toggleSwitchSerializer->method('serialize')->willReturn(['test-serialized-toggle-switch']);
        $standbyPowerSwitchModel = self::createStub(StandbyPowerSwitchInterface::class);
        $standbyPowerSwitchSerializer = self::createStub(StandbyPowerSwitchSerializerInterface::class);
        $standbyPowerSwitchSerializer->method('serialize')->willReturn(['test-serialized-standby-power-switch']);
        $switchControlModel = self::createStub(SwitchControlInterface::class);
        $switchControlSerializer = self::createStub(SwitchControlSerializerInterface::class);
        $switchControlSerializer->method('serialize')->willReturn(['test-serialized-switch-control']);
        $sliderTypeModel = self::createStub(SliderTypeInterface::class);
        $sliderTypeSerializer = self::createStub(SliderTypeSerializerInterface::class);
        $sliderTypeSerializer->method('serialize')->willReturn(['test-serialized-slider-type']);
        $pushButtonModel = self::createStub(PushButtonInterface::class);
        $pushButtonSerializer = self::createStub(PushButtonSerializerInterface::class);
        $pushButtonSerializer->method('serialize')->willReturn(['test-serialized-push-button']);
        $textButtonModel = self::createStub(TextButtonInterface::class);
        $textButtonSerializer = self::createStub(TextButtonSerializerInterface::class);
        $textButtonSerializer->method('serialize')->willReturn(['test-serialized-text-button']);
        $playPauseModel = self::createStub(PlayPauseInterface::class);
        $playPauseSerializer = self::createStub(PlayPauseSerializerInterface::class);
        $playPauseSerializer->method('serialize')->willReturn(['test-serialized-play-pause']);
        $playStopModel = self::createStub(PlayStopInterface::class);
        $playStopSerializer = self::createStub(PlayStopSerializerInterface::class);
        $playStopSerializer->method('serialize')->willReturn(['test-serialized-play-stop']);
        $listForDetailViewModel = self::createStub(ListForDetailViewInterface::class);
        $listForDetailViewSerializer = self::createStub(ListForDetailViewSerializerInterface::class);
        $listForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-list-for-detail-view']);
        $textFieldModel = self::createStub(TextFieldInterface::class);
        $textFieldSerializer = self::createStub(TextFieldSerializerInterface::class);
        $textFieldSerializer->method('serialize')->willReturn(['test-serialized-text-field']);
        $numberFieldModel = self::createStub(NumberFieldInterface::class);
        $numberFieldSerializer = self::createStub(NumberFieldSerializerInterface::class);
        $numberFieldSerializer->method('serialize')->willReturn(['test-serialized-number-field']);
        $stepperModel = self::createStub(StepperInterface::class);
        $stepperSerializer = self::createStub(StepperSerializerInterface::class);
        $stepperSerializer->method('serialize')->willReturn(['test-serialized-stepper']);
        $stateModel = self::createStub(StateInterface::class);
        $stateSerializer = self::createStub(StateSerializerInterface::class);
        $stateSerializer->method('serialize')->willReturn(['test-serialized-state']);
        $visibleConditionBaseModel = self::createStub(VisibleConditionBaseInterface::class);
        $visibleConditionBaseSerializer = self::createStub(VisibleConditionBaseSerializerInterface::class);
        $visibleConditionBaseSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-base']);
        $model = (new CreateCapabilityPresentationRequestDetailViewItem('test-label', 'test-display-type'))
            ->setToggleSwitch($toggleSwitchModel)
            ->setStandbyPowerSwitch($standbyPowerSwitchModel)
            ->setSwitch($switchControlModel)
            ->setSlider($sliderTypeModel)
            ->setPushButton($pushButtonModel)
            ->setTextButton($textButtonModel)
            ->setPlayPause($playPauseModel)
            ->setPlayStop($playStopModel)
            ->setList($listForDetailViewModel)
            ->setTextField($textFieldModel)
            ->setNumberField($numberFieldModel)
            ->setStepper($stepperModel)
            ->setState($stateModel)
            ->setVisibleCondition($visibleConditionBaseModel);

        $serializer = new CreateCapabilityPresentationRequestDetailViewItemSerializer($toggleSwitchSerializer, $standbyPowerSwitchSerializer, $switchControlSerializer, $sliderTypeSerializer, $pushButtonSerializer, $textButtonSerializer, $playPauseSerializer, $playStopSerializer, $listForDetailViewSerializer, $textFieldSerializer, $numberFieldSerializer, $stepperSerializer, $stateSerializer, $visibleConditionBaseSerializer);

        self::assertSame(
            [
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_LABEL => 'test-label',
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_DISPLAY_TYPE => 'test-display-type',
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_TOGGLE_SWITCH => ['test-serialized-toggle-switch'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_STANDBY_POWER_SWITCH => ['test-serialized-standby-power-switch'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_SWITCH => ['test-serialized-switch-control'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_SLIDER => ['test-serialized-slider-type'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_PUSH_BUTTON => ['test-serialized-push-button'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_TEXT_BUTTON => ['test-serialized-text-button'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_PLAY_PAUSE => ['test-serialized-play-pause'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_PLAY_STOP => ['test-serialized-play-stop'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_LIST => ['test-serialized-list-for-detail-view'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_TEXT_FIELD => ['test-serialized-text-field'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_NUMBER_FIELD => ['test-serialized-number-field'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_STEPPER => ['test-serialized-stepper'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_STATE => ['test-serialized-state'],
                CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition-base'],
            ],
            $serializer->serialize($model)
        );
    }
}
