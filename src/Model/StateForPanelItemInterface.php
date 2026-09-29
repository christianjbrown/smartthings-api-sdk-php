<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StateForPanelItemInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getLabel(): string;

    public function getSize(): string;

    public function getUnit(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setUnit(?string $value): self;
}
