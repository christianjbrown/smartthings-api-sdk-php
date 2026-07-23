<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaPage implements SchemaPageInterface
{
    private ?string $appName = null;
    private ?string $isaId = null;
    private ?string $locationId = null;
    private ?string $oAuthLink = null;
    private string $pageType;
    private ?string $partnerName = null;

    public function __construct(string $pageType)
    {
        $this->pageType = $pageType;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function getIsaId(): ?string
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

    public function getPageType(): string
    {
        return $this->pageType;
    }

    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    public function setAppName(?string $value): SchemaPageInterface
    {
        $this->appName = $value;

        return $this;
    }

    public function setIsaId(?string $value): SchemaPageInterface
    {
        $this->isaId = $value;

        return $this;
    }

    public function setLocationId(?string $value): SchemaPageInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setOAuthLink(?string $value): SchemaPageInterface
    {
        $this->oAuthLink = $value;

        return $this;
    }

    public function setPageType(string $value): SchemaPageInterface
    {
        $this->pageType = $value;

        return $this;
    }

    public function setPartnerName(?string $value): SchemaPageInterface
    {
        $this->partnerName = $value;

        return $this;
    }
}
