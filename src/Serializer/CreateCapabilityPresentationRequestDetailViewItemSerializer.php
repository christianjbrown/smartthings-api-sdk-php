<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;
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

use function array_filter;

final class CreateCapabilityPresentationRequestDetailViewItemSerializer implements CreateCapabilityPresentationRequestDetailViewItemSerializerInterface
{
    private ListForDetailViewSerializerInterface $listForDetailViewSerializer;
    private NumberFieldSerializerInterface $numberFieldSerializer;
    private PlayPauseSerializerInterface $playPauseSerializer;
    private PlayStopSerializerInterface $playStopSerializer;
    private PushButtonSerializerInterface $pushButtonSerializer;
    private SliderTypeSerializerInterface $sliderTypeSerializer;
    private StandbyPowerSwitchSerializerInterface $standbyPowerSwitchSerializer;
    private StateSerializerInterface $stateSerializer;
    private StepperSerializerInterface $stepperSerializer;
    private SwitchControlSerializerInterface $switchControlSerializer;
    private TextButtonSerializerInterface $textButtonSerializer;
    private TextFieldSerializerInterface $textFieldSerializer;
    private ToggleSwitchSerializerInterface $toggleSwitchSerializer;
    private VisibleConditionBaseSerializerInterface $visibleConditionBaseSerializer;

    public function __construct(ToggleSwitchSerializerInterface $toggleSwitchSerializer, StandbyPowerSwitchSerializerInterface $standbyPowerSwitchSerializer, SwitchControlSerializerInterface $switchControlSerializer, SliderTypeSerializerInterface $sliderTypeSerializer, PushButtonSerializerInterface $pushButtonSerializer, TextButtonSerializerInterface $textButtonSerializer, PlayPauseSerializerInterface $playPauseSerializer, PlayStopSerializerInterface $playStopSerializer, ListForDetailViewSerializerInterface $listForDetailViewSerializer, TextFieldSerializerInterface $textFieldSerializer, NumberFieldSerializerInterface $numberFieldSerializer, StepperSerializerInterface $stepperSerializer, StateSerializerInterface $stateSerializer, VisibleConditionBaseSerializerInterface $visibleConditionBaseSerializer)
    {
        $this->toggleSwitchSerializer = $toggleSwitchSerializer;
        $this->standbyPowerSwitchSerializer = $standbyPowerSwitchSerializer;
        $this->switchControlSerializer = $switchControlSerializer;
        $this->sliderTypeSerializer = $sliderTypeSerializer;
        $this->pushButtonSerializer = $pushButtonSerializer;
        $this->textButtonSerializer = $textButtonSerializer;
        $this->playPauseSerializer = $playPauseSerializer;
        $this->playStopSerializer = $playStopSerializer;
        $this->listForDetailViewSerializer = $listForDetailViewSerializer;
        $this->textFieldSerializer = $textFieldSerializer;
        $this->numberFieldSerializer = $numberFieldSerializer;
        $this->stepperSerializer = $stepperSerializer;
        $this->stateSerializer = $stateSerializer;
        $this->visibleConditionBaseSerializer = $visibleConditionBaseSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(CreateCapabilityPresentationRequestDetailViewItemInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_TOGGLE_SWITCH => $this->serializeOptionalToggleSwitch($model->getToggleSwitch()),
            self::KEY_STANDBY_POWER_SWITCH => $this->serializeOptionalStandbyPowerSwitch($model->getStandbyPowerSwitch()),
            self::KEY_SWITCH => $this->serializeOptionalSwitch($model->getSwitch()),
            self::KEY_SLIDER => $this->serializeOptionalSlider($model->getSlider()),
            self::KEY_PUSH_BUTTON => $this->serializeOptionalPushButton($model->getPushButton()),
            self::KEY_TEXT_BUTTON => $this->serializeOptionalTextButton($model->getTextButton()),
            self::KEY_PLAY_PAUSE => $this->serializeOptionalPlayPause($model->getPlayPause()),
            self::KEY_PLAY_STOP => $this->serializeOptionalPlayStop($model->getPlayStop()),
            self::KEY_LIST => $this->serializeOptionalList($model->getList()),
            self::KEY_TEXT_FIELD => $this->serializeOptionalTextField($model->getTextField()),
            self::KEY_NUMBER_FIELD => $this->serializeOptionalNumberField($model->getNumberField()),
            self::KEY_STEPPER => $this->serializeOptionalStepper($model->getStepper()),
            self::KEY_STATE => $this->serializeOptionalState($model->getState()),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalList(?ListForDetailViewInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listForDetailViewSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalNumberField(?NumberFieldInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->numberFieldSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayPause(?PlayPauseInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playPauseSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayStop(?PlayStopInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playStopSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPushButton(?PushButtonInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->pushButtonSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSlider(?SliderTypeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->sliderTypeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStandbyPowerSwitch(?StandbyPowerSwitchInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->standbyPowerSwitchSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalState(?StateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->stateSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStepper(?StepperInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->stepperSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSwitch(?SwitchControlInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->switchControlSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTextButton(?TextButtonInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->textButtonSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTextField(?TextFieldInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->textFieldSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalToggleSwitch(?ToggleSwitchInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->toggleSwitchSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionBaseInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionBaseSerializer->serialize($value);
    }
}
