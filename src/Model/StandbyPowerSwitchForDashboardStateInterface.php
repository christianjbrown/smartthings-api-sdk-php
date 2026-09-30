<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StandbyPowerSwitchForDashboardStateInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getLabel(): ?string;

    public function getOff(): ?string;

    public function getOn(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    public function setLabel(?string $value): self;

    public function setValueType(?string $value): self;
}
