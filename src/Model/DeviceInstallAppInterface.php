<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceInstallAppInterface
{
    public function getExternalId(): ?string;

    public function getInstalledAppId(): string;

    public function getProfileId(): string;

    public function setExternalId(?string $value): self;
}
