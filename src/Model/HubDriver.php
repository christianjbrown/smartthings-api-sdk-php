<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubDriver implements HubDriverInterface
{
    private ?string $channelId = null;
    private string $driverId;
    private ?string $driverVersion = null;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    public function getDriverVersion(): ?string
    {
        return $this->driverVersion;
    }

    public function setChannelId(?string $value): HubDriverInterface
    {
        $this->channelId = $value;

        return $this;
    }

    public function setDriverVersion(?string $value): HubDriverInterface
    {
        $this->driverVersion = $value;

        return $this;
    }
}
