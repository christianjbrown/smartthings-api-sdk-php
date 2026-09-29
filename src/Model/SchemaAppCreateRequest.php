<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppCreateRequest implements SchemaAppCreateRequestInterface
{
    private string $appName;
    private ?string $certificationStatus = null;
    private ?string $endpointAppId = null;
    private string $hostingType;
    private ?string $icon = null;
    private ?string $icon2x = null;
    private ?string $icon3x = null;
    private ?string $lambdaArn = null;
    private ?string $lambdaArnAP = null;
    private ?string $lambdaArnCN = null;
    private ?string $lambdaArnEU = null;
    private string $oAuthAuthorizationUrl;
    private string $oAuthClientId;
    private string $oAuthClientSecret;
    private ?string $oAuthScope = null;
    private string $oAuthTokenUrl;
    private string $partnerName;
    private ?string $schemaType = null;
    private string $userEmail;
    private ?string $userId = null;
    private ?ViperAppLinksInterface $viperAppLinks = null;
    private ?string $webhookUrl = null;

    public function __construct(string $appName, string $partnerName, string $oAuthAuthorizationUrl, string $oAuthClientId, string $oAuthClientSecret, string $oAuthTokenUrl, string $hostingType, string $userEmail)
    {
        $this->appName = $appName;
        $this->partnerName = $partnerName;
        $this->oAuthAuthorizationUrl = $oAuthAuthorizationUrl;
        $this->oAuthClientId = $oAuthClientId;
        $this->oAuthClientSecret = $oAuthClientSecret;
        $this->oAuthTokenUrl = $oAuthTokenUrl;
        $this->hostingType = $hostingType;
        $this->userEmail = $userEmail;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function getCertificationStatus(): ?string
    {
        return $this->certificationStatus;
    }

    public function getEndpointAppId(): ?string
    {
        return $this->endpointAppId;
    }

    public function getHostingType(): string
    {
        return $this->hostingType;
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

    public function getLambdaArn(): ?string
    {
        return $this->lambdaArn;
    }

    public function getLambdaArnAP(): ?string
    {
        return $this->lambdaArnAP;
    }

    public function getLambdaArnCN(): ?string
    {
        return $this->lambdaArnCN;
    }

    public function getLambdaArnEU(): ?string
    {
        return $this->lambdaArnEU;
    }

    public function getOAuthAuthorizationUrl(): string
    {
        return $this->oAuthAuthorizationUrl;
    }

    public function getOAuthClientId(): string
    {
        return $this->oAuthClientId;
    }

    public function getOAuthClientSecret(): string
    {
        return $this->oAuthClientSecret;
    }

    public function getOAuthScope(): ?string
    {
        return $this->oAuthScope;
    }

    public function getOAuthTokenUrl(): string
    {
        return $this->oAuthTokenUrl;
    }

    public function getPartnerName(): string
    {
        return $this->partnerName;
    }

    public function getSchemaType(): ?string
    {
        return $this->schemaType;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getViperAppLinks(): ?ViperAppLinksInterface
    {
        return $this->viperAppLinks;
    }

    public function getWebhookUrl(): ?string
    {
        return $this->webhookUrl;
    }

    public function setCertificationStatus(?string $value): SchemaAppCreateRequestInterface
    {
        $this->certificationStatus = $value;

        return $this;
    }

    public function setEndpointAppId(?string $value): SchemaAppCreateRequestInterface
    {
        $this->endpointAppId = $value;

        return $this;
    }

    public function setIcon(?string $value): SchemaAppCreateRequestInterface
    {
        $this->icon = $value;

        return $this;
    }

    public function setIcon2x(?string $value): SchemaAppCreateRequestInterface
    {
        $this->icon2x = $value;

        return $this;
    }

    public function setIcon3x(?string $value): SchemaAppCreateRequestInterface
    {
        $this->icon3x = $value;

        return $this;
    }

    public function setLambdaArn(?string $value): SchemaAppCreateRequestInterface
    {
        $this->lambdaArn = $value;

        return $this;
    }

    public function setLambdaArnAP(?string $value): SchemaAppCreateRequestInterface
    {
        $this->lambdaArnAP = $value;

        return $this;
    }

    public function setLambdaArnCN(?string $value): SchemaAppCreateRequestInterface
    {
        $this->lambdaArnCN = $value;

        return $this;
    }

    public function setLambdaArnEU(?string $value): SchemaAppCreateRequestInterface
    {
        $this->lambdaArnEU = $value;

        return $this;
    }

    public function setOAuthScope(?string $value): SchemaAppCreateRequestInterface
    {
        $this->oAuthScope = $value;

        return $this;
    }

    public function setSchemaType(?string $value): SchemaAppCreateRequestInterface
    {
        $this->schemaType = $value;

        return $this;
    }

    public function setUserId(?string $value): SchemaAppCreateRequestInterface
    {
        $this->userId = $value;

        return $this;
    }

    public function setViperAppLinks(?ViperAppLinksInterface $value): SchemaAppCreateRequestInterface
    {
        $this->viperAppLinks = $value;

        return $this;
    }

    public function setWebhookUrl(?string $value): SchemaAppCreateRequestInterface
    {
        $this->webhookUrl = $value;

        return $this;
    }
}
