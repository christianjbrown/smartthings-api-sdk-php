<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppConfigInterface
{
    /**
     * @return mixed[]
     */
    public function getConfig(): array;

    public function getConfigurationId(): string;

    public function getConfigurationStatus(): ?string;

    public function getCreatedDate(): ?string;

    public function getInstalledAppId(): ?string;

    public function getLastUpdatedDate(): ?string;

    /**
     * @param mixed[] $value
     */
    public function setConfig(array $value): self;

    public function setConfigurationId(string $value): self;

    public function setConfigurationStatus(?string $value): self;

    public function setCreatedDate(?string $value): self;

    public function setInstalledAppId(?string $value): self;

    public function setLastUpdatedDate(?string $value): self;
}
