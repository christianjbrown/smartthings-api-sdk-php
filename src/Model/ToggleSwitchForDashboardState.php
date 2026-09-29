<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ToggleSwitchForDashboardState implements ToggleSwitchForDashboardStateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private string $off;
    private string $on;
    private ?string $value = null;
    private ?string $valueType = null;

    public function __construct(string $on, string $off)
    {
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

    public function getOff(): string
    {
        return $this->off;
    }

    public function getOn(): string
    {
        return $this->on;
    }

    public function getValue(): ?string
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
    public function setAlternatives(?array $value): ToggleSwitchForDashboardStateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setValue(?string $value): ToggleSwitchForDashboardStateInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setValueType(?string $value): ToggleSwitchForDashboardStateInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
