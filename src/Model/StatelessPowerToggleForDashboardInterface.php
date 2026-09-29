<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StatelessPowerToggleForDashboardInterface
{
    public function getArgument(): ?string;

    public function getArgumentType(): ?string;

    public function getCommand(): string;

    public function setArgument(?string $value): self;

    public function setArgumentType(?string $value): self;
}
