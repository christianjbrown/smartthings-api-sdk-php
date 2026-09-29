<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandSequenceInterface
{
    public function getCommands(): ?string;

    public function getDevices(): ?string;

    public function setCommands(?string $value): self;

    public function setDevices(?string $value): self;
}
