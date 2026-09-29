<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AutomationForCapabilityActionsItem implements AutomationForCapabilityActionsItemInterface
{
    private ?string $description = null;
    private string $displayType;
    private ?DynamicListForAutomationActionInterface $dynamicList = null;
    private ?bool $emphasis = null;
    private string $label;
    private ?ListForAutomationActionInterface $list = null;
    private ?MultiArgCommandInterface $multiArgCommand = null;
    private ?NumberFieldForAutomationActionInterface $numberField = null;
    private ?SliderForAutomationActionInterface $slider = null;
    private ?TextFieldForAutomationActionInterface $textField = null;
    private ?VisibleConditionBaseInterface $visibleCondition = null;

    public function __construct(string $label, string $displayType)
    {
        $this->label = $label;
        $this->displayType = $displayType;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDisplayType(): string
    {
        return $this->displayType;
    }

    public function getDynamicList(): ?DynamicListForAutomationActionInterface
    {
        return $this->dynamicList;
    }

    public function getEmphasis(): ?bool
    {
        return $this->emphasis;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getList(): ?ListForAutomationActionInterface
    {
        return $this->list;
    }

    public function getMultiArgCommand(): ?MultiArgCommandInterface
    {
        return $this->multiArgCommand;
    }

    public function getNumberField(): ?NumberFieldForAutomationActionInterface
    {
        return $this->numberField;
    }

    public function getSlider(): ?SliderForAutomationActionInterface
    {
        return $this->slider;
    }

    public function getTextField(): ?TextFieldForAutomationActionInterface
    {
        return $this->textField;
    }

    public function getVisibleCondition(): ?VisibleConditionBaseInterface
    {
        return $this->visibleCondition;
    }

    public function setDescription(?string $value): AutomationForCapabilityActionsItemInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDynamicList(?DynamicListForAutomationActionInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->dynamicList = $value;

        return $this;
    }

    public function setEmphasis(?bool $value): AutomationForCapabilityActionsItemInterface
    {
        $this->emphasis = $value;

        return $this;
    }

    public function setList(?ListForAutomationActionInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setMultiArgCommand(?MultiArgCommandInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->multiArgCommand = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldForAutomationActionInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setSlider(?SliderForAutomationActionInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setTextField(?TextFieldForAutomationActionInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->textField = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionBaseInterface $value): AutomationForCapabilityActionsItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
