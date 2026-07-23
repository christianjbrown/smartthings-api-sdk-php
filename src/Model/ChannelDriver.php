<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ChannelDriver implements ChannelDriverInterface
{
    private ?string $channelId = null;
    private string $driverId;
    private ?string $version = null;

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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setChannelId(?string $value): ChannelDriverInterface
    {
        $this->channelId = $value;

        return $this;
    }

    public function setDriverId(string $value): ChannelDriverInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setVersion(?string $value): ChannelDriverInterface
    {
        $this->version = $value;

        return $this;
    }
}
