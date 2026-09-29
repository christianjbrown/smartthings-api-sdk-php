<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DriverChannelUpdateRequest implements DriverChannelUpdateRequestInterface
{
    private ?string $version = null;

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $value): DriverChannelUpdateRequestInterface
    {
        $this->version = $value;

        return $this;
    }
}
