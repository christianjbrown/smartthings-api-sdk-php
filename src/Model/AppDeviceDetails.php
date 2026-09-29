<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AppDeviceDetails implements AppDeviceDetailsInterface
{
    private ?string $externalId = null;
    private ?string $installedAppId = null;
    private ?DeviceProfileReferenceInterface $profile = null;

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function getProfile(): ?DeviceProfileReferenceInterface
    {
        return $this->profile;
    }

    public function setExternalId(?string $value): AppDeviceDetailsInterface
    {
        $this->externalId = $value;

        return $this;
    }

    public function setInstalledAppId(?string $value): AppDeviceDetailsInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setProfile(?DeviceProfileReferenceInterface $value): AppDeviceDetailsInterface
    {
        $this->profile = $value;

        return $this;
    }
}
