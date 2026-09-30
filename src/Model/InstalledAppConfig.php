<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledAppConfig implements InstalledAppConfigInterface
{
    /**
     * @var mixed[]
     */
    private array $config = [];

    /**
     * @var array<array-key, array<int, ConfigEntryInterface>>
     */
    private array $configEntries = [];
    private string $configurationId;
    private ?string $configurationStatus = null;
    private ?string $createdDate = null;
    private ?string $installedAppId = null;
    private ?string $lastUpdatedDate = null;

    public function __construct(string $configurationId)
    {
        $this->configurationId = $configurationId;
    }

    /**
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return array<array-key, array<int, ConfigEntryInterface>>
     */
    public function getConfigEntries(): array
    {
        return $this->configEntries;
    }

    public function getConfigurationId(): string
    {
        return $this->configurationId;
    }

    public function getConfigurationStatus(): ?string
    {
        return $this->configurationStatus;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function getLastUpdatedDate(): ?string
    {
        return $this->lastUpdatedDate;
    }

    /**
     * @param mixed[] $value
     */
    public function setConfig(array $value): InstalledAppConfigInterface
    {
        $this->config = $value;

        return $this;
    }

    /**
     * @param array<array-key, array<int, ConfigEntryInterface>> $value
     */
    public function setConfigEntries(array $value): InstalledAppConfigInterface
    {
        $this->configEntries = $value;

        return $this;
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

    public function setCreatedDate(?string $value): InstalledAppConfigInterface
    {
        $this->createdDate = $value;

        return $this;
    }

    public function setInstalledAppId(?string $value): InstalledAppConfigInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setLastUpdatedDate(?string $value): InstalledAppConfigInterface
    {
        $this->lastUpdatedDate = $value;

        return $this;
    }
}
