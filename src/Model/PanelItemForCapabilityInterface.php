<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PanelItemForCapabilityInterface
{
    public function getDisplayType(): string;

    public function getEmpty(): ?EmptyWithAvailableSizeInterface;

    public function getLabel(): ?string;

    public function getList(): ?ListWithAvailableSizeInterface;

    public function getPushButton(): ?PushButtonWithAvailableSizeInterface;

    public function getSlider(): ?SliderWithAvailableSizeInterface;

    public function getState(): ?StateWithAvailableSizeInterface;

    public function getStepper(): ?StepperWithAvailableSizeInterface;

    public function setEmpty(?EmptyWithAvailableSizeInterface $value): self;

    public function setLabel(?string $value): self;

    public function setList(?ListWithAvailableSizeInterface $value): self;

    public function setPushButton(?PushButtonWithAvailableSizeInterface $value): self;

    public function setSlider(?SliderWithAvailableSizeInterface $value): self;

    public function setState(?StateWithAvailableSizeInterface $value): self;

    public function setStepper(?StepperWithAvailableSizeInterface $value): self;
}
