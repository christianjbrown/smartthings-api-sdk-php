<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListForPanelItemStateInterface
{
    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    public function setValueType(?string $value): self;
}
