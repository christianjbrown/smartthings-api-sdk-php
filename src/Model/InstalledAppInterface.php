<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppInterface
{
    public function getAppId(): ?string;

    public function getDisplayName(): ?string;

    public function getInstalledAppId(): string;

    public function getInstalledAppStatus(): ?string;

    public function getInstalledAppType(): ?string;

    public function getLocationId(): ?string;

    public function setAppId(?string $value): self;

    public function setDisplayName(?string $value): self;

    public function setInstalledAppId(string $value): self;

    public function setInstalledAppStatus(?string $value): self;

    public function setInstalledAppType(?string $value): self;

    public function setLocationId(?string $value): self;
}
