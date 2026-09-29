<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppCreateRequestInterface
{
    public function getAppName(): string;

    public function getCertificationStatus(): ?string;

    public function getEndpointAppId(): ?string;

    public function getHostingType(): string;

    public function getIcon(): ?string;

    public function getIcon2x(): ?string;

    public function getIcon3x(): ?string;

    public function getLambdaArn(): ?string;

    public function getLambdaArnAP(): ?string;

    public function getLambdaArnCN(): ?string;

    public function getLambdaArnEU(): ?string;

    public function getOAuthAuthorizationUrl(): string;

    public function getOAuthClientId(): string;

    public function getOAuthClientSecret(): string;

    public function getOAuthScope(): ?string;

    public function getOAuthTokenUrl(): string;

    public function getPartnerName(): string;

    public function getSchemaType(): ?string;

    public function getUserEmail(): string;

    public function getUserId(): ?string;

    public function getViperAppLinks(): ?ViperAppLinksInterface;

    public function getWebhookUrl(): ?string;

    public function setCertificationStatus(?string $value): self;

    public function setEndpointAppId(?string $value): self;

    public function setIcon(?string $value): self;

    public function setIcon2x(?string $value): self;

    public function setIcon3x(?string $value): self;

    public function setLambdaArn(?string $value): self;

    public function setLambdaArnAP(?string $value): self;

    public function setLambdaArnCN(?string $value): self;

    public function setLambdaArnEU(?string $value): self;

    public function setOAuthScope(?string $value): self;

    public function setSchemaType(?string $value): self;

    public function setUserId(?string $value): self;

    public function setViperAppLinks(?ViperAppLinksInterface $value): self;

    public function setWebhookUrl(?string $value): self;
}
