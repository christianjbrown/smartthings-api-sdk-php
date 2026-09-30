<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StringConfigInterface
{
    public function getValue(): ?string;

    public function setValue(?string $value): self;
}
