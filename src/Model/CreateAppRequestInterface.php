<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateAppRequestInterface
{
    public function getAppName(): string;

    public function getAppType(): string;

    /**
     * @return array<int, string>
     */
    public function getClassifications(): array;

    public function getDescription(): string;

    public function getDisplayName(): string;

    public function getIconImage(): ?IconImageInterface;

    public function getLambdaSmartApp(): ?CreateOrUpdateLambdaSmartAppRequestInterface;

    public function getOauth(): ?AppOauthDefinitionInterface;

    public function getPrincipalType(): ?string;

    public function getSingleInstance(): ?bool;

    public function getUi(): ?AppUiSettingsInterface;

    public function getWebhookSmartApp(): ?CreateOrUpdateWebhookSmartAppRequestInterface;

    public function setIconImage(?IconImageInterface $value): self;

    public function setLambdaSmartApp(?CreateOrUpdateLambdaSmartAppRequestInterface $value): self;

    public function setOauth(?AppOauthDefinitionInterface $value): self;

    public function setPrincipalType(?string $value): self;

    public function setSingleInstance(?bool $value): self;

    public function setUi(?AppUiSettingsInterface $value): self;

    public function setWebhookSmartApp(?CreateOrUpdateWebhookSmartAppRequestInterface $value): self;
}
