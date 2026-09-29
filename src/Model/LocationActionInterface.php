<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationActionInterface
{
    public function getLocationId(): ?string;

    public function getMode(): ?string;

    public function setLocationId(?string $value): self;

    public function setMode(?string $value): self;
}
