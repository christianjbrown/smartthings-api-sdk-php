<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListForAutomationConditionInterface
{
    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array;

    public function getMultiSelectable(): ?bool;

    public function getSupportedValues(): ?string;

    public function getValue(): string;

    public function getValueType(): ?string;

    public function setMultiSelectable(?bool $value): self;

    public function setSupportedValues(?string $value): self;

    public function setValueType(?string $value): self;
}
