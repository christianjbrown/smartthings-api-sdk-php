<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubDriverInstallRequest implements HubDriverInstallRequestInterface
{
    private ?string $channelId = null;

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelId(?string $value): HubDriverInstallRequestInterface
    {
        $this->channelId = $value;

        return $this;
    }
}
