<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledSchemaApp implements InstalledSchemaAppInterface
{
    private ?string $appName = null;
    private string $isaId;
    private ?string $locationId = null;
    private ?string $oAuthLink = null;
    private ?string $pageType = null;
    private ?string $partnerName = null;

    public function __construct(string $isaId)
    {
        $this->isaId = $isaId;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
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

    public function setAppName(?string $value): InstalledSchemaAppInterface
    {
        $this->appName = $value;

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
}
