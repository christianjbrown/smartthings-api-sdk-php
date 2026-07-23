<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubInstalledDriver implements HubInstalledDriverInterface
{
    private ?string $channelId = null;
    private ?string $description = null;
    private ?string $developer = null;
    private string $driverId;
    private ?string $name = null;
    private ?string $vendorSupportInformation = null;
    private ?string $version = null;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDeveloper(): ?string
    {
        return $this->developer;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getVendorSupportInformation(): ?string
    {
        return $this->vendorSupportInformation;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setChannelId(?string $value): HubInstalledDriverInterface
    {
        $this->channelId = $value;

        return $this;
    }

    public function setDescription(?string $value): HubInstalledDriverInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDeveloper(?string $value): HubInstalledDriverInterface
    {
        $this->developer = $value;

        return $this;
    }

    public function setDriverId(string $value): HubInstalledDriverInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setName(?string $value): HubInstalledDriverInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setVendorSupportInformation(?string $value): HubInstalledDriverInterface
    {
        $this->vendorSupportInformation = $value;

        return $this;
    }

    public function setVersion(?string $value): HubInstalledDriverInterface
    {
        $this->version = $value;

        return $this;
    }
}
