<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PageLinkInterface
{
    public function getHref(): ?string;

    public function setHref(?string $value): self;
}
