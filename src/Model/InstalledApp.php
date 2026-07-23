<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledApp implements InstalledAppInterface
{
    private ?string $appId = null;
    private ?string $displayName = null;
    private string $installedAppId;
    private ?string $installedAppStatus = null;
    private ?string $installedAppType = null;
    private ?string $locationId = null;

    public function __construct(string $installedAppId)
    {
        $this->installedAppId = $installedAppId;
    }

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function getInstalledAppId(): string
    {
        return $this->installedAppId;
    }

    public function getInstalledAppStatus(): ?string
    {
        return $this->installedAppStatus;
    }

    public function getInstalledAppType(): ?string
    {
        return $this->installedAppType;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function setAppId(?string $value): InstalledAppInterface
    {
        $this->appId = $value;

        return $this;
    }

    public function setDisplayName(?string $value): InstalledAppInterface
    {
        $this->displayName = $value;

        return $this;
    }

    public function setInstalledAppId(string $value): InstalledAppInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setInstalledAppStatus(?string $value): InstalledAppInterface
    {
        $this->installedAppStatus = $value;

        return $this;
    }

    public function setInstalledAppType(?string $value): InstalledAppInterface
    {
        $this->installedAppType = $value;

        return $this;
    }

    public function setLocationId(?string $value): InstalledAppInterface
    {
        $this->locationId = $value;

        return $this;
    }
}
