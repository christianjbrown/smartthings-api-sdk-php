<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledAppConfig implements InstalledAppConfigInterface
{
    private string $configurationId;
    private ?string $configurationStatus = null;
    private ?string $installedAppId = null;

    public function __construct(string $configurationId)
    {
        $this->configurationId = $configurationId;
    }

    public function getConfigurationId(): string
    {
        return $this->configurationId;
    }

    public function getConfigurationStatus(): ?string
    {
        return $this->configurationStatus;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function setConfigurationId(string $value): InstalledAppConfigInterface
    {
        $this->configurationId = $value;

        return $this;
    }

    public function setConfigurationStatus(?string $value): InstalledAppConfigInterface
    {
        $this->configurationStatus = $value;

        return $this;
    }

    public function setInstalledAppId(?string $value): InstalledAppConfigInterface
    {
        $this->installedAppId = $value;

        return $this;
    }
}
