<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ModeConfigInterface
{
    public function getModeId(): ?string;

    public function setModeId(?string $value): self;
}
