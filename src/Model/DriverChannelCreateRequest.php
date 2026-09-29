<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DriverChannelCreateRequest implements DriverChannelCreateRequestInterface
{
    private ?string $driverId = null;
    private ?string $version = null;

    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setDriverId(?string $value): DriverChannelCreateRequestInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setVersion(?string $value): DriverChannelCreateRequestInterface
    {
        $this->version = $value;

        return $this;
    }
}
