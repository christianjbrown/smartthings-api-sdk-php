<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ActionListItemInterface
{
    public function getCapability(): ?string;

    public function getComponent(): ?string;

    public function getDescription(): ?string;

    public function getDisplayType(): ?string;

    public function getDynamicList(): ?DynamicListForAutomationActionInterface;

    public function getEmphasis(): ?bool;

    /**
     * @return null|array<int, ExcludedActionItemInterface>
     */
    public function getExclusion(): ?array;

    public function getLabel(): ?string;

    public function getList(): ?ListForAutomationActionInterface;

    public function getMultiArgCommand(): ?MultiArgCommandInterface;

    public function getNumberField(): ?NumberFieldForAutomationActionInterface;

    public function getSlider(): ?SliderForAutomationActionInterface;

    public function getTextField(): ?TextFieldForAutomationActionInterface;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionInterface;

    public function setComponent(?string $value): self;

    public function setDescription(?string $value): self;

    public function setDynamicList(?DynamicListForAutomationActionInterface $value): self;

    public function setEmphasis(?bool $value): self;

    /**
     * @param null|array<int, ExcludedActionItemInterface> $value
     */
    public function setExclusion(?array $value): self;

    public function setList(?ListForAutomationActionInterface $value): self;

    public function setMultiArgCommand(?MultiArgCommandInterface $value): self;

    public function setNumberField(?NumberFieldForAutomationActionInterface $value): self;

    public function setSlider(?SliderForAutomationActionInterface $value): self;

    public function setTextField(?TextFieldForAutomationActionInterface $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionInterface $value): self;
}
