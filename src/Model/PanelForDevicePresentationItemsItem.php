<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PanelForDevicePresentationItemsItem implements PanelForDevicePresentationItemsItemInterface
{
    private string $capability;
    private string $component;
    private string $displayType;
    private ?EmptyForPanelItemInterface $empty = null;
    private ?bool $hideOnUnmatch = null;
    private ?string $label = null;
    private ?ListForPanelItemInterface $list = null;
    private ?string $operator = null;
    private ?PushButtonForPanelItemInterface $pushButton = null;
    private ?SliderForPanelItemInterface $slider = null;
    private ?StateForPanelItemInterface $state = null;
    private ?StepperForPanelItemInterface $stepper = null;
    private ?int $version = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(string $capability, string $component, string $displayType)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->displayType = $displayType;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function getDisplayType(): string
    {
        return $this->displayType;
    }

    public function getEmpty(): ?EmptyForPanelItemInterface
    {
        return $this->empty;
    }

    public function getHideOnUnmatch(): ?bool
    {
        return $this->hideOnUnmatch;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getList(): ?ListForPanelItemInterface
    {
        return $this->list;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function getPushButton(): ?PushButtonForPanelItemInterface
    {
        return $this->pushButton;
    }

    public function getSlider(): ?SliderForPanelItemInterface
    {
        return $this->slider;
    }

    public function getState(): ?StateForPanelItemInterface
    {
        return $this->state;
    }

    public function getStepper(): ?StepperForPanelItemInterface
    {
        return $this->stepper;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    public function setEmpty(?EmptyForPanelItemInterface $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->empty = $value;

        return $this;
    }

    public function setHideOnUnmatch(?bool $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->hideOnUnmatch = $value;

        return $this;
    }

    public function setLabel(?string $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setList(?ListForPanelItemInterface $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setOperator(?string $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->operator = $value;

        return $this;
    }

    public function setPushButton(?PushButtonForPanelItemInterface $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->pushButton = $value;

        return $this;
    }

    public function setSlider(?SliderForPanelItemInterface $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setState(?StateForPanelItemInterface $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->state = $value;

        return $this;
    }

    public function setStepper(?StepperForPanelItemInterface $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->stepper = $value;

        return $this;
    }

    public function setVersion(?int $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->version = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): PanelForDevicePresentationItemsItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
