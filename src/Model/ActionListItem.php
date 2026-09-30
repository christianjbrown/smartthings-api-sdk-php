<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ActionListItem implements ActionListItemInterface
{
    private ?string $capability;
    private ?string $component = null;
    private ?string $description = null;
    private ?string $displayType;
    private ?DynamicListForAutomationActionInterface $dynamicList = null;
    private ?bool $emphasis = null;

    /**
     * @var null|array<int, ExcludedActionItemInterface>
     */
    private ?array $exclusion = null;
    private ?string $label;
    private ?ListForAutomationActionInterface $list = null;
    private ?MultiArgCommandInterface $multiArgCommand = null;
    private ?NumberFieldForAutomationActionInterface $numberField = null;
    private ?SliderForAutomationActionInterface $slider = null;
    private ?TextFieldForAutomationActionInterface $textField = null;
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

    public function getDynamicList(): ?DynamicListForAutomationActionInterface
    {
        return $this->dynamicList;
    }

    public function getEmphasis(): ?bool
    {
        return $this->emphasis;
    }

    /**
     * @return null|array<int, ExcludedActionItemInterface>
     */
    public function getExclusion(): ?array
    {
        return $this->exclusion;
    }

    public function getLabel(): ?string
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

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionInterface
    {
        return $this->visibleCondition;
    }

    public function setComponent(?string $value): ActionListItemInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setDescription(?string $value): ActionListItemInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDynamicList(?DynamicListForAutomationActionInterface $value): ActionListItemInterface
    {
        $this->dynamicList = $value;

        return $this;
    }

    public function setEmphasis(?bool $value): ActionListItemInterface
    {
        $this->emphasis = $value;

        return $this;
    }

    /**
     * @param null|array<int, ExcludedActionItemInterface> $value
     */
    public function setExclusion(?array $value): ActionListItemInterface
    {
        $this->exclusion = $value;

        return $this;
    }

    public function setList(?ListForAutomationActionInterface $value): ActionListItemInterface
    {
        $this->list = $value;

        return $this;
    }

    public function setMultiArgCommand(?MultiArgCommandInterface $value): ActionListItemInterface
    {
        $this->multiArgCommand = $value;

        return $this;
    }

    public function setNumberField(?NumberFieldForAutomationActionInterface $value): ActionListItemInterface
    {
        $this->numberField = $value;

        return $this;
    }

    public function setSlider(?SliderForAutomationActionInterface $value): ActionListItemInterface
    {
        $this->slider = $value;

        return $this;
    }

    public function setTextField(?TextFieldForAutomationActionInterface $value): ActionListItemInterface
    {
        $this->textField = $value;

        return $this;
    }

    public function setVersion(?int $value): ActionListItemInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): ActionListItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
