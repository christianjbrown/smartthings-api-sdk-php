<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DynamicListForAutomationConditionInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getMultiSelectable(): ?bool;

    public function getSupportedValues(): SupportedValuesForDynamicListInterface;

    public function getValue(): string;

    public function getValueType(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setMultiSelectable(?bool $value): self;

    public function setValueType(?string $value): self;
}
