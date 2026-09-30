<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ToggleSwitchForDashboardCommandInterface
{
    public function getArgumentType(): ?string;

    public function getName(): ?string;

    public function getOff(): ?string;

    public function getOn(): ?string;

    public function setArgumentType(?string $value): self;

    public function setName(?string $value): self;
}
