<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubDriverInstallRequestInterface
{
    public function getChannelId(): ?string;

    public function setChannelId(?string $value): self;
}
