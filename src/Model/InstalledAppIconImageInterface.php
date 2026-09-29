<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppIconImageInterface
{
    public function getUrl(): ?string;

    public function setUrl(?string $value): self;
}
