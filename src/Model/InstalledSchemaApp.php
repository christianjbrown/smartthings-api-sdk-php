<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledSchemaApp implements InstalledSchemaAppInterface
{
    private ?string $appName = null;

    /**
     * @var array<int, DeviceResultsInterface>
     */
    private array $devices = [];
    private ?string $driverId = null;
    private ?string $endpointAppId = null;
    private ?string $icon = null;
    private ?string $icon2x = null;
    private ?string $icon3x = null;
    private string $isaId;
    private ?string $locationId = null;
    private ?string $oAuthLink = null;
    private ?string $pageType = null;
    private ?string $partnerName = null;
    private ?string $partnerSTConnection = null;
    private ?string $stEulaFileName = null;
    private ?string $stEulaLocksmithKey = null;
    private ?ViperAppLinksInterface $viperAppLinks = null;

    public function __construct(string $isaId)
    {
        $this->isaId = $isaId;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    /**
     * @return array<int, DeviceResultsInterface>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }

    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    public function getEndpointAppId(): ?string
    {
        return $this->endpointAppId;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getIcon2x(): ?string
    {
        return $this->icon2x;
    }

    public function getIcon3x(): ?string
    {
        return $this->icon3x;
    }

    public function getIsaId(): string
    {
        return $this->isaId;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getOAuthLink(): ?string
    {
        return $this->oAuthLink;
    }

    public function getPageType(): ?string
    {
        return $this->pageType;
    }

    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    public function getPartnerSTConnection(): ?string
    {
        return $this->partnerSTConnection;
    }

    public function getStEulaFileName(): ?string
    {
        return $this->stEulaFileName;
    }

    public function getStEulaLocksmithKey(): ?string
    {
        return $this->stEulaLocksmithKey;
    }

    public function getViperAppLinks(): ?ViperAppLinksInterface
    {
        return $this->viperAppLinks;
    }

    public function setAppName(?string $value): InstalledSchemaAppInterface
    {
        $this->appName = $value;

        return $this;
    }

    /**
     * @param array<int, DeviceResultsInterface> $value
     */
    public function setDevices(array $value): InstalledSchemaAppInterface
    {
        $this->devices = $value;

        return $this;
    }

    public function setDriverId(?string $value): InstalledSchemaAppInterface
    {
        $this->driverId = $value;

        return $this;
    }

    public function setEndpointAppId(?string $value): InstalledSchemaAppInterface
    {
        $this->endpointAppId = $value;

        return $this;
    }

    public function setIcon(?string $value): InstalledSchemaAppInterface
    {
        $this->icon = $value;

        return $this;
    }

    public function setIcon2x(?string $value): InstalledSchemaAppInterface
    {
        $this->icon2x = $value;

        return $this;
    }

    public function setIcon3x(?string $value): InstalledSchemaAppInterface
    {
        $this->icon3x = $value;

        return $this;
    }

    public function setIsaId(string $value): InstalledSchemaAppInterface
    {
        $this->isaId = $value;

        return $this;
    }

    public function setLocationId(?string $value): InstalledSchemaAppInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setOAuthLink(?string $value): InstalledSchemaAppInterface
    {
        $this->oAuthLink = $value;

        return $this;
    }

    public function setPageType(?string $value): InstalledSchemaAppInterface
    {
        $this->pageType = $value;

        return $this;
    }

    public function setPartnerName(?string $value): InstalledSchemaAppInterface
    {
        $this->partnerName = $value;

        return $this;
    }

    public function setPartnerSTConnection(?string $value): InstalledSchemaAppInterface
    {
        $this->partnerSTConnection = $value;

        return $this;
    }

    public function setStEulaFileName(?string $value): InstalledSchemaAppInterface
    {
        $this->stEulaFileName = $value;

        return $this;
    }

    public function setStEulaLocksmithKey(?string $value): InstalledSchemaAppInterface
    {
        $this->stEulaLocksmithKey = $value;

        return $this;
    }

    public function setViperAppLinks(?ViperAppLinksInterface $value): InstalledSchemaAppInterface
    {
        $this->viperAppLinks = $value;

        return $this;
    }
}
