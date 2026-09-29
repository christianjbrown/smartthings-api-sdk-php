<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityValueForDashboardStateInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getLabel(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setLabel(?string $value): self;
}
