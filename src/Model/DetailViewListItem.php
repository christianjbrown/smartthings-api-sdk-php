<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DetailViewListItem implements DetailViewListItemInterface
{
    private string $capability;
    private ?string $component = null;
    private string $displayType;
    private string $label;
    private ?ListForDetailViewInterface $list = null;
    private ?MultiArgCommandInterface $multiArgCommand = null;
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
    private ?int $version = null;
    private ?VisibleConditionForDetailViewInterface $visibleCondition = null;

    public function __construct(string $capability, string $label, string $displayType)
    {
        $this->capability = $capability;
        $this->label = $label;
        $this->displayType = $displayType;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
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

    public function getMultiArgCommand(): ?MultiArgCommandInterface
    {
        return $this->multiArgCommand;
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

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionForDetailViewInterface
    {
        return $this->visibleCondition;
    }

    public function setComponent(?string $value): DetailViewListItemInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setList(?ListForDetailViewInterface $value): DetailViewListItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setMultiArgCommand(?MultiArgCommandInterface $value): DetailViewListItemInterface
    {
        $this->multiArgCommand = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldInterface $value): DetailViewListItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setPlayPause(?PlayPauseInterface $value): DetailViewListItemInterface
    {
        $this->playPause = $value;

        return $this;
    }

    public function setPlayStop(?PlayStopInterface $value): DetailViewListItemInterface
    {
        $this->playStop = $value;

        return $this;
    }

    public function setPushButton(?PushButtonInterface $value): DetailViewListItemInterface
    {
        $this->pushButton = $value;

        return $this;
    }

    public function setSlider(?SliderTypeInterface $value): DetailViewListItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setStandbyPowerSwitch(?StandbyPowerSwitchInterface $value): DetailViewListItemInterface
    {
        $this->standbyPowerSwitch = $value;

        return $this;
    }

    public function setState(?StateInterface $value): DetailViewListItemInterface
    {
        $this->state = $value;

        return $this;
    }

    public function setStepper(?StepperInterface $value): DetailViewListItemInterface
    {
        $this->stepper = $value;

        return $this;
    }

    public function setSwitch(?SwitchControlInterface $value): DetailViewListItemInterface
    {
        $this->switch = $value;

        return $this;
    }

    public function setTextButton(?TextButtonInterface $value): DetailViewListItemInterface
    {
        $this->textButton = $value;

        return $this;
    }

    public function setTextField(?TextFieldInterface $value): DetailViewListItemInterface
    {
        $this->textField = $value;

        return $this;
    }

    public function setToggleSwitch(?ToggleSwitchInterface $value): DetailViewListItemInterface
    {
        $this->toggleSwitch = $value;

        return $this;
    }

    public function setVersion(?int $value): DetailViewListItemInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionForDetailViewInterface $value): DetailViewListItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
