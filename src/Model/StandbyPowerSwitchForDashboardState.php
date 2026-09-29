<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StandbyPowerSwitchForDashboardState implements StandbyPowerSwitchForDashboardStateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $label = null;
    private string $off;
    private string $on;
    private string $value;
    private ?string $valueType = null;

    public function __construct(string $value, string $on, string $off)
    {
        $this->value = $value;
        $this->on = $on;
        $this->off = $off;
    }

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

    public function getOff(): string
    {
        return $this->off;
    }

    public function getOn(): string
    {
        return $this->on;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): StandbyPowerSwitchForDashboardStateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setLabel(?string $value): StandbyPowerSwitchForDashboardStateInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setValueType(?string $value): StandbyPowerSwitchForDashboardStateInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
