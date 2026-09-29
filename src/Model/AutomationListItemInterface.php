<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AutomationListItemInterface
{
    public function getCapability(): string;

    public function getComponent(): ?string;

    public function getDescription(): ?string;

    public function getDisplayType(): string;

    public function getDynamicList(): ?DynamicListForAutomationConditionInterface;

    public function getEmphasis(): ?bool;

    public function getEnumSlider(): ?EnumSliderForAutomationConditionInterface;

    /**
     * @return null|array<int, ExcludedConditionItemInterface>
     */
    public function getExclusion(): ?array;

    public function getLabel(): string;

    public function getList(): ?ListForAutomationConditionInterface;

    public function getNumberField(): ?NumberFieldForAutomationConditionInterface;

    public function getSlider(): ?SliderForAutomationConditionInterface;

    public function getTextField(): ?TextFieldForAutomationConditionInterface;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionInterface;

    public function setComponent(?string $value): self;

    public function setDescription(?string $value): self;

    public function setDynamicList(?DynamicListForAutomationConditionInterface $value): self;

    public function setEmphasis(?bool $value): self;

    public function setEnumSlider(?EnumSliderForAutomationConditionInterface $value): self;

    /**
     * @param null|array<int, ExcludedConditionItemInterface> $value
     */
    public function setExclusion(?array $value): self;

    public function setList(?ListForAutomationConditionInterface $value): self;

    public function setNumberField(?NumberFieldForAutomationConditionInterface $value): self;

    public function setSlider(?SliderForAutomationConditionInterface $value): self;

    public function setTextField(?TextFieldForAutomationConditionInterface $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionInterface $value): self;
}
