<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaApp implements SchemaAppInterface
{
    private ?string $appName = null;
    private ?string $certificationStatus = null;
    private string $endpointAppId;
    private ?string $partnerName = null;
    private ?string $stClientId = null;

    public function __construct(string $endpointAppId)
    {
        $this->endpointAppId = $endpointAppId;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function getCertificationStatus(): ?string
    {
        return $this->certificationStatus;
    }

    public function getEndpointAppId(): string
    {
        return $this->endpointAppId;
    }

    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    public function getStClientId(): ?string
    {
        return $this->stClientId;
    }

    public function setAppName(?string $value): SchemaAppInterface
    {
        $this->appName = $value;

        return $this;
    }

    public function setCertificationStatus(?string $value): SchemaAppInterface
    {
        $this->certificationStatus = $value;

        return $this;
    }

    public function setEndpointAppId(string $value): SchemaAppInterface
    {
        $this->endpointAppId = $value;

        return $this;
    }

    public function setPartnerName(?string $value): SchemaAppInterface
    {
        $this->partnerName = $value;

        return $this;
    }

    public function setStClientId(?string $value): SchemaAppInterface
    {
        $this->stClientId = $value;

        return $this;
    }
}
