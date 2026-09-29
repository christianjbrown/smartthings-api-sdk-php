<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ChannelDriver implements ChannelDriverInterface
{
    private ?string $channelId = null;
    private ?string $createdDate = null;
    private string $driverId;
    private ?string $lastModifiedDate = null;
    private ?string $version = null;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    public function getLastModifiedDate(): ?string
    {
        return $this->lastModifiedDate;
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

    public function setCreatedDate(?string $value): ChannelDriverInterface
    {
        $this->createdDate = $value;

        return $this;
    }

    public function setDriverId(string $value): ChannelDriverInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setLastModifiedDate(?string $value): ChannelDriverInterface
    {
        $this->lastModifiedDate = $value;

        return $this;
    }

    public function setVersion(?string $value): ChannelDriverInterface
    {
        $this->version = $value;

        return $this;
    }
}
