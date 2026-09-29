<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateCapabilityPresentationRequestDetailViewItemInterface
{
    public function getDisplayType(): string;

    public function getLabel(): string;

    public function getList(): ?ListForDetailViewInterface;

    public function getNumberField(): ?NumberFieldInterface;

    public function getPlayPause(): ?PlayPauseInterface;

    public function getPlayStop(): ?PlayStopInterface;

    public function getPushButton(): ?PushButtonInterface;

    public function getSlider(): ?SliderTypeInterface;

    public function getStandbyPowerSwitch(): ?StandbyPowerSwitchInterface;

    public function getState(): ?StateInterface;

    public function getStepper(): ?StepperInterface;

    public function getSwitch(): ?SwitchControlInterface;

    public function getTextButton(): ?TextButtonInterface;

    public function getTextField(): ?TextFieldInterface;

    public function getToggleSwitch(): ?ToggleSwitchInterface;

    public function getVisibleCondition(): ?VisibleConditionBaseInterface;

    public function setList(?ListForDetailViewInterface $value): self;

    public function setNumberField(?NumberFieldInterface $value): self;

    public function setPlayPause(?PlayPauseInterface $value): self;

    public function setPlayStop(?PlayStopInterface $value): self;

    public function setPushButton(?PushButtonInterface $value): self;

    public function setSlider(?SliderTypeInterface $value): self;

    public function setStandbyPowerSwitch(?StandbyPowerSwitchInterface $value): self;

    public function setState(?StateInterface $value): self;

    public function setStepper(?StepperInterface $value): self;

    public function setSwitch(?SwitchControlInterface $value): self;

    public function setTextButton(?TextButtonInterface $value): self;

    public function setTextField(?TextFieldInterface $value): self;

    public function setToggleSwitch(?ToggleSwitchInterface $value): self;

    public function setVisibleCondition(?VisibleConditionBaseInterface $value): self;
}
