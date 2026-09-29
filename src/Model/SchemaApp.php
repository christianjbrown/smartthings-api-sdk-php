<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaApp implements SchemaAppInterface
{
    private ?string $appName = null;
    private ?string $certificationStatus = null;
    private string $endpointAppId;
    private ?string $hostingType = null;
    private ?string $icon = null;
    private ?string $icon2x = null;
    private ?string $icon3x = null;
    private ?string $lambdaArn = null;
    private ?string $lambdaArnAP = null;
    private ?string $lambdaArnCN = null;
    private ?string $lambdaArnEU = null;
    private ?string $oAuthAuthorizationUrl = null;
    private ?string $oAuthClientId = null;
    private ?string $oAuthClientSecret = null;
    private ?string $oAuthScope = null;
    private ?string $oAuthTokenUrl = null;
    private ?string $organizationId = null;
    private ?string $partnerName = null;
    private ?string $schemaType = null;
    private ?string $stClientId = null;
    private ?string $userEmail = null;
    private ?string $userId = null;
    private ?ViperAppLinksInterface $viperAppLinks = null;
    private ?string $webhookUrl = null;

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

    public function getHostingType(): ?string
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

    public function getOAuthAuthorizationUrl(): ?string
    {
        return $this->oAuthAuthorizationUrl;
    }

    public function getOAuthClientId(): ?string
    {
        return $this->oAuthClientId;
    }

    public function getOAuthClientSecret(): ?string
    {
        return $this->oAuthClientSecret;
    }

    public function getOAuthScope(): ?string
    {
        return $this->oAuthScope;
    }

    public function getOAuthTokenUrl(): ?string
    {
        return $this->oAuthTokenUrl;
    }

    public function getOrganizationId(): ?string
    {
        return $this->organizationId;
    }

    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }

    public function getSchemaType(): ?string
    {
        return $this->schemaType;
    }

    public function getStClientId(): ?string
    {
        return $this->stClientId;
    }

    public function getUserEmail(): ?string
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

    public function setHostingType(?string $value): SchemaAppInterface
    {
        $this->hostingType = $value;

        return $this;
    }

    public function setIcon(?string $value): SchemaAppInterface
    {
        $this->icon = $value;

        return $this;
    }

    public function setIcon2x(?string $value): SchemaAppInterface
    {
        $this->icon2x = $value;

        return $this;
    }

    public function setIcon3x(?string $value): SchemaAppInterface
    {
        $this->icon3x = $value;

        return $this;
    }

    public function setLambdaArn(?string $value): SchemaAppInterface
    {
        $this->lambdaArn = $value;

        return $this;
    }

    public function setLambdaArnAP(?string $value): SchemaAppInterface
    {
        $this->lambdaArnAP = $value;

        return $this;
    }

    public function setLambdaArnCN(?string $value): SchemaAppInterface
    {
        $this->lambdaArnCN = $value;

        return $this;
    }

    public function setLambdaArnEU(?string $value): SchemaAppInterface
    {
        $this->lambdaArnEU = $value;

        return $this;
    }

    public function setOAuthAuthorizationUrl(?string $value): SchemaAppInterface
    {
        $this->oAuthAuthorizationUrl = $value;

        return $this;
    }

    public function setOAuthClientId(?string $value): SchemaAppInterface
    {
        $this->oAuthClientId = $value;

        return $this;
    }

    public function setOAuthClientSecret(?string $value): SchemaAppInterface
    {
        $this->oAuthClientSecret = $value;

        return $this;
    }

    public function setOAuthScope(?string $value): SchemaAppInterface
    {
        $this->oAuthScope = $value;

        return $this;
    }

    public function setOAuthTokenUrl(?string $value): SchemaAppInterface
    {
        $this->oAuthTokenUrl = $value;

        return $this;
    }

    public function setOrganizationId(?string $value): SchemaAppInterface
    {
        $this->organizationId = $value;

        return $this;
    }

    public function setPartnerName(?string $value): SchemaAppInterface
    {
        $this->partnerName = $value;

        return $this;
    }

    public function setSchemaType(?string $value): SchemaAppInterface
    {
        $this->schemaType = $value;

        return $this;
    }

    public function setStClientId(?string $value): SchemaAppInterface
    {
        $this->stClientId = $value;

        return $this;
    }

    public function setUserEmail(?string $value): SchemaAppInterface
    {
        $this->userEmail = $value;

        return $this;
    }

    public function setUserId(?string $value): SchemaAppInterface
    {
        $this->userId = $value;

        return $this;
    }

    public function setViperAppLinks(?ViperAppLinksInterface $value): SchemaAppInterface
    {
        $this->viperAppLinks = $value;

        return $this;
    }

    public function setWebhookUrl(?string $value): SchemaAppInterface
    {
        $this->webhookUrl = $value;

        return $this;
    }
}
