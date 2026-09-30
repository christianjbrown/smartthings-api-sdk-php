<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AutomationListItem implements AutomationListItemInterface
{
    private ?string $capability;
    private ?string $component = null;
    private ?string $description = null;
    private ?string $displayType;
    private ?DynamicListForAutomationConditionInterface $dynamicList = null;
    private ?bool $emphasis = null;
    private ?EnumSliderForAutomationConditionInterface $enumSlider = null;

    /**
     * @var null|array<int, ExcludedConditionItemInterface>
     */
    private ?array $exclusion = null;
    private ?string $label;
    private ?ListForAutomationConditionInterface $list = null;
    private ?NumberFieldForAutomationConditionInterface $numberField = null;
    private ?SliderForAutomationConditionInterface $slider = null;
    private ?TextFieldForAutomationConditionInterface $textField = null;
    private ?int $version = null;
    private ?VisibleConditionInterface $visibleCondition = null;

    public function __construct(?string $capability, ?string $label, ?string $displayType)
    {
        $this->capability = $capability;
        $this->label = $label;
        $this->displayType = $displayType;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
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

    /**
     * @return null|array<int, ExcludedConditionItemInterface>
     */
    public function getExclusion(): ?array
    {
        return $this->exclusion;
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

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionInterface
    {
        return $this->visibleCondition;
    }

    public function setComponent(?string $value): AutomationListItemInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setDescription(?string $value): AutomationListItemInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDynamicList(?DynamicListForAutomationConditionInterface $value): AutomationListItemInterface
    {
        $this->dynamicList = $value;

        return $this;
    }

    public function setEmphasis(?bool $value): AutomationListItemInterface
    {
        $this->emphasis = $value;

        return $this;
    }

    public function setEnumSlider(?EnumSliderForAutomationConditionInterface $value): AutomationListItemInterface
    {
        $this->enumSlider = $value;

        return $this;
    }

    /**
     * @param null|array<int, ExcludedConditionItemInterface> $value
     */
    public function setExclusion(?array $value): AutomationListItemInterface
    {
        $this->exclusion = $value;

        return $this;
    }

    public function setList(?ListForAutomationConditionInterface $value): AutomationListItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldForAutomationConditionInterface $value): AutomationListItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setSlider(?SliderForAutomationConditionInterface $value): AutomationListItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setTextField(?TextFieldForAutomationConditionInterface $value): AutomationListItemInterface
    {
        $this->textField = $value;

        return $this;
    }

    public function setVersion(?int $value): AutomationListItemInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): AutomationListItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
