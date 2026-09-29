<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledSchemaAppInterface
{
    public function getAppName(): ?string;

    /**
     * @return array<int, DeviceResultsInterface>
     */
    public function getDevices(): array;

    public function getDriverId(): ?string;

    public function getEndpointAppId(): ?string;

    public function getIcon(): ?string;

    public function getIcon2x(): ?string;

    public function getIcon3x(): ?string;

    public function getIsaId(): string;

    public function getLocationId(): ?string;

    public function getOAuthLink(): ?string;

    public function getPageType(): ?string;

    public function getPartnerName(): ?string;

    public function getPartnerSTConnection(): ?string;

    public function getStEulaFileName(): ?string;

    public function getStEulaLocksmithKey(): ?string;

    public function getViperAppLinks(): ?ViperAppLinksInterface;

    public function setAppName(?string $value): self;

    /**
     * @param array<int, DeviceResultsInterface> $value
     */
    public function setDevices(array $value): self;

    public function setDriverId(?string $value): self;

    public function setEndpointAppId(?string $value): self;

    public function setIcon(?string $value): self;

    public function setIcon2x(?string $value): self;

    public function setIcon3x(?string $value): self;

    public function setIsaId(string $value): self;

    public function setLocationId(?string $value): self;

    public function setOAuthLink(?string $value): self;

    public function setPageType(?string $value): self;

    public function setPartnerName(?string $value): self;

    public function setPartnerSTConnection(?string $value): self;

    public function setStEulaFileName(?string $value): self;

    public function setStEulaLocksmithKey(?string $value): self;

    public function setViperAppLinks(?ViperAppLinksInterface $value): self;
}
