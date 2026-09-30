<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ToggleSwitchForDashboardCommand implements ToggleSwitchForDashboardCommandInterface
{
    private ?string $argumentType = null;
    private ?string $name = null;
    private ?string $off;
    private ?string $on;

    public function __construct(?string $on, ?string $off)
    {
        $this->on = $on;
        $this->off = $off;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOff(): ?string
    {
        return $this->off;
    }

    public function getOn(): ?string
    {
        return $this->on;
    }

    public function setArgumentType(?string $value): ToggleSwitchForDashboardCommandInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setName(?string $value): ToggleSwitchForDashboardCommandInterface
    {
        $this->name = $value;

        return $this;
    }
}
