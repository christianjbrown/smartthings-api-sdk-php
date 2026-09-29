<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AutomationForCapabilityActionsItemInterface
{
    public function getDescription(): ?string;

    public function getDisplayType(): string;

    public function getDynamicList(): ?DynamicListForAutomationActionInterface;

    public function getEmphasis(): ?bool;

    public function getLabel(): string;

    public function getList(): ?ListForAutomationActionInterface;

    public function getMultiArgCommand(): ?MultiArgCommandInterface;

    public function getNumberField(): ?NumberFieldForAutomationActionInterface;

    public function getSlider(): ?SliderForAutomationActionInterface;

    public function getTextField(): ?TextFieldForAutomationActionInterface;

    public function getVisibleCondition(): ?VisibleConditionBaseInterface;

    public function setDescription(?string $value): self;

    public function setDynamicList(?DynamicListForAutomationActionInterface $value): self;

    public function setEmphasis(?bool $value): self;

    public function setList(?ListForAutomationActionInterface $value): self;

    public function setMultiArgCommand(?MultiArgCommandInterface $value): self;

    public function setNumberField(?NumberFieldForAutomationActionInterface $value): self;

    public function setSlider(?SliderForAutomationActionInterface $value): self;

    public function setTextField(?TextFieldForAutomationActionInterface $value): self;

    public function setVisibleCondition(?VisibleConditionBaseInterface $value): self;
}
