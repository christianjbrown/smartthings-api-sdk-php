<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StepperForPanelItemStateInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getLabel(): ?string;

    public function getUnit(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setLabel(?string $value): self;

    public function setUnit(?string $value): self;

    public function setValueType(?string $value): self;
}
