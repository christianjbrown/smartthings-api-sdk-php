<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PanelItemForCapability implements PanelItemForCapabilityInterface
{
    private ?string $displayType;
    private ?EmptyWithAvailableSizeInterface $empty = null;
    private ?string $label = null;
    private ?ListWithAvailableSizeInterface $list = null;
    private ?PushButtonWithAvailableSizeInterface $pushButton = null;
    private ?SliderWithAvailableSizeInterface $slider = null;
    private ?StateWithAvailableSizeInterface $state = null;
    private ?StepperWithAvailableSizeInterface $stepper = null;

    public function __construct(?string $displayType)
    {
        $this->displayType = $displayType;
    }

    public function getDisplayType(): ?string
    {
        return $this->displayType;
    }

    public function getEmpty(): ?EmptyWithAvailableSizeInterface
    {
        return $this->empty;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getList(): ?ListWithAvailableSizeInterface
    {
        return $this->list;
    }

    public function getPushButton(): ?PushButtonWithAvailableSizeInterface
    {
        return $this->pushButton;
    }

    public function getSlider(): ?SliderWithAvailableSizeInterface
    {
        return $this->slider;
    }

    public function getState(): ?StateWithAvailableSizeInterface
    {
        return $this->state;
    }

    public function getStepper(): ?StepperWithAvailableSizeInterface
    {
        return $this->stepper;
    }

    public function setEmpty(?EmptyWithAvailableSizeInterface $value): PanelItemForCapabilityInterface
    {
        $this->empty = $value;

        return $this;
    }

    public function setLabel(?string $value): PanelItemForCapabilityInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setList(?ListWithAvailableSizeInterface $value): PanelItemForCapabilityInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setPushButton(?PushButtonWithAvailableSizeInterface $value): PanelItemForCapabilityInterface
    {
        $this->pushButton = $value;

        return $this;
    }

    public function setSlider(?SliderWithAvailableSizeInterface $value): PanelItemForCapabilityInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setState(?StateWithAvailableSizeInterface $value): PanelItemForCapabilityInterface
    {
        $this->state = $value;

        return $this;
    }

    public function setStepper(?StepperWithAvailableSizeInterface $value): PanelItemForCapabilityInterface
    {
        $this->stepper = $value;

        return $this;
    }
}
