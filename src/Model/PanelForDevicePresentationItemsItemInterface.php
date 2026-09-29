<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PanelForDevicePresentationItemsItemInterface
{
    public function getCapability(): string;

    public function getComponent(): string;

    public function getDisplayType(): string;

    public function getEmpty(): ?EmptyForPanelItemInterface;

    public function getHideOnUnmatch(): ?bool;

    public function getLabel(): ?string;

    public function getList(): ?ListForPanelItemInterface;

    public function getOperator(): ?string;

    public function getPushButton(): ?PushButtonForPanelItemInterface;

    public function getSlider(): ?SliderForPanelItemInterface;

    public function getState(): ?StateForPanelItemInterface;

    public function getStepper(): ?StepperForPanelItemInterface;

    public function getVersion(): ?int;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setEmpty(?EmptyForPanelItemInterface $value): self;

    public function setHideOnUnmatch(?bool $value): self;

    public function setLabel(?string $value): self;

    public function setList(?ListForPanelItemInterface $value): self;

    public function setOperator(?string $value): self;

    public function setPushButton(?PushButtonForPanelItemInterface $value): self;

    public function setSlider(?SliderForPanelItemInterface $value): self;

    public function setState(?StateForPanelItemInterface $value): self;

    public function setStepper(?StepperForPanelItemInterface $value): self;

    public function setVersion(?int $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
