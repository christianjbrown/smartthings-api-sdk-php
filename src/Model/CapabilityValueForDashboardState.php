<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityValueForDashboardState implements CapabilityValueForDashboardStateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $label = null;

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): CapabilityValueForDashboardStateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setLabel(?string $value): CapabilityValueForDashboardStateInterface
    {
        $this->label = $value;

        return $this;
    }
}
