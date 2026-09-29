<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PlayPauseCommandInterface
{
    public function getArgumentType(): ?string;

    public function getName(): ?string;

    public function getPause(): string;

    public function getPlay(): string;

    public function setArgumentType(?string $value): self;

    public function setName(?string $value): self;
}
