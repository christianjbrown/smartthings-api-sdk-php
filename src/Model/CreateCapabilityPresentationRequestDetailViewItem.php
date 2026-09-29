<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateCapabilityPresentationRequestDetailViewItem implements CreateCapabilityPresentationRequestDetailViewItemInterface
{
    private string $displayType;
    private string $label;
    private ?ListForDetailViewInterface $list = null;
    private ?NumberFieldInterface $numberField = null;
    private ?PlayPauseInterface $playPause = null;
    private ?PlayStopInterface $playStop = null;
    private ?PushButtonInterface $pushButton = null;
    private ?SliderTypeInterface $slider = null;
    private ?StandbyPowerSwitchInterface $standbyPowerSwitch = null;
    private ?StateInterface $state = null;
    private ?StepperInterface $stepper = null;
    private ?SwitchControlInterface $switch = null;
    private ?TextButtonInterface $textButton = null;
    private ?TextFieldInterface $textField = null;
    private ?ToggleSwitchInterface $toggleSwitch = null;
    private ?VisibleConditionBaseInterface $visibleCondition = null;

    public function __construct(string $label, string $displayType)
    {
        $this->label = $label;
        $this->displayType = $displayType;
    }

    public function getDisplayType(): string
    {
        return $this->displayType;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getList(): ?ListForDetailViewInterface
    {
        return $this->list;
    }

    public function getNumberField(): ?NumberFieldInterface
    {
        return $this->numberField;
    }

    public function getPlayPause(): ?PlayPauseInterface
    {
        return $this->playPause;
    }

    public function getPlayStop(): ?PlayStopInterface
    {
        return $this->playStop;
    }

    public function getPushButton(): ?PushButtonInterface
    {
        return $this->pushButton;
    }

    public function getSlider(): ?SliderTypeInterface
    {
        return $this->slider;
    }

    public function getStandbyPowerSwitch(): ?StandbyPowerSwitchInterface
    {
        return $this->standbyPowerSwitch;
    }

    public function getState(): ?StateInterface
    {
        return $this->state;
    }

    public function getStepper(): ?StepperInterface
    {
        return $this->stepper;
    }

    public function getSwitch(): ?SwitchControlInterface
    {
        return $this->switch;
    }

    public function getTextButton(): ?TextButtonInterface
    {
        return $this->textButton;
    }

    public function getTextField(): ?TextFieldInterface
    {
        return $this->textField;
    }

    public function getToggleSwitch(): ?ToggleSwitchInterface
    {
        return $this->toggleSwitch;
    }

    public function getVisibleCondition(): ?VisibleConditionBaseInterface
    {
        return $this->visibleCondition;
    }

    public function setList(?ListForDetailViewInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setPlayPause(?PlayPauseInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->playPause = $value;

        return $this;
    }

    public function setPlayStop(?PlayStopInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->playStop = $value;

        return $this;
    }

    public function setPushButton(?PushButtonInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->pushButton = $value;

        return $this;
    }

    public function setSlider(?SliderTypeInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setStandbyPowerSwitch(?StandbyPowerSwitchInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->standbyPowerSwitch = $value;

        return $this;
    }

    public function setState(?StateInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->state = $value;

        return $this;
    }

    public function setStepper(?StepperInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->stepper = $value;

        return $this;
    }

    public function setSwitch(?SwitchControlInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->switch = $value;

        return $this;
    }

    public function setTextButton(?TextButtonInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->textButton = $value;

        return $this;
    }

    public function setTextField(?TextFieldInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->textField = $value;

        return $this;
    }

    public function setToggleSwitch(?ToggleSwitchInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->toggleSwitch = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionBaseInterface $value): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
