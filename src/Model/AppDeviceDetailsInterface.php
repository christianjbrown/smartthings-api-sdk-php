<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppDeviceDetailsInterface
{
    public function getExternalId(): ?string;

    public function getInstalledAppId(): ?string;

    public function getProfile(): ?DeviceProfileReferenceInterface;

    public function setExternalId(?string $value): self;

    public function setInstalledAppId(?string $value): self;

    public function setProfile(?DeviceProfileReferenceInterface $value): self;
}
