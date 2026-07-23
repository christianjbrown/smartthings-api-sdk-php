<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppConfigInterface
{
    public function getConfigurationId(): string;

    public function getConfigurationStatus(): ?string;

    public function getInstalledAppId(): ?string;

    public function setConfigurationId(string $value): self;

    public function setConfigurationStatus(?string $value): self;

    public function setInstalledAppId(?string $value): self;
}
