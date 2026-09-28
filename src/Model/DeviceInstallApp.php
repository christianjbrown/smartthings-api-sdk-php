<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceInstallApp implements DeviceInstallAppInterface
{
    private ?string $externalId = null;
    private string $installedAppId;
    private string $profileId;

    public function __construct(string $profileId, string $installedAppId)
    {
        $this->profileId = $profileId;
        $this->installedAppId = $installedAppId;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getInstalledAppId(): string
    {
        return $this->installedAppId;
    }

    public function getProfileId(): string
    {
        return $this->profileId;
    }

    public function setExternalId(?string $value): DeviceInstallAppInterface
    {
        $this->externalId = $value;

        return $this;
    }
}
