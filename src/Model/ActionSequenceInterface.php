<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ActionSequenceInterface
{
    public function getActions(): ?string;

    public function setActions(?string $value): self;
}
