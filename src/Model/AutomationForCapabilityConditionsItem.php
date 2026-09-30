<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AutomationForCapabilityConditionsItem implements AutomationForCapabilityConditionsItemInterface
{
    private ?string $description = null;
    private ?string $displayType;
    private ?DynamicListForAutomationConditionInterface $dynamicList = null;
    private ?bool $emphasis = null;
    private ?EnumSliderForAutomationConditionInterface $enumSlider = null;
    private ?string $label;
    private ?ListForAutomationConditionInterface $list = null;
    private ?NumberFieldForAutomationConditionInterface $numberField = null;
    private ?SliderForAutomationConditionInterface $slider = null;
    private ?TextFieldForAutomationConditionInterface $textField = null;
    private ?VisibleConditionBaseInterface $visibleCondition = null;

    public function __construct(?string $label, ?string $displayType)
    {
        $this->label = $label;
        $this->displayType = $displayType;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDisplayType(): ?string
    {
        return $this->displayType;
    }

    public function getDynamicList(): ?DynamicListForAutomationConditionInterface
    {
        return $this->dynamicList;
    }

    public function getEmphasis(): ?bool
    {
        return $this->emphasis;
    }

    public function getEnumSlider(): ?EnumSliderForAutomationConditionInterface
    {
        return $this->enumSlider;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getList(): ?ListForAutomationConditionInterface
    {
        return $this->list;
    }

    public function getNumberField(): ?NumberFieldForAutomationConditionInterface
    {
        return $this->numberField;
    }

    public function getSlider(): ?SliderForAutomationConditionInterface
    {
        return $this->slider;
    }

    public function getTextField(): ?TextFieldForAutomationConditionInterface
    {
        return $this->textField;
    }

    public function getVisibleCondition(): ?VisibleConditionBaseInterface
    {
        return $this->visibleCondition;
    }

    public function setDescription(?string $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDynamicList(?DynamicListForAutomationConditionInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->dynamicList = $value;

        return $this;
    }

    public function setEmphasis(?bool $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->emphasis = $value;

        return $this;
    }

    public function setEnumSlider(?EnumSliderForAutomationConditionInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->enumSlider = $value;

        return $this;
    }

    public function setList(?ListForAutomationConditionInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldForAutomationConditionInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setSlider(?SliderForAutomationConditionInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setTextField(?TextFieldForAutomationConditionInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->textField = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionBaseInterface $value): AutomationForCapabilityConditionsItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
