<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverChannelUpdateRequestInterface
{
    public function getVersion(): ?string;

    public function setVersion(?string $value): self;
}
