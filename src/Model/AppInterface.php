<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppInterface
{
    public function getAppId(): string;

    public function getAppName(): ?string;

    public function getAppType(): ?string;

    /**
     * @return array<int, string>
     */
    public function getClassifications(): array;

    public function getCreatedDate(): ?string;

    public function getDescription(): ?string;

    public function getDisplayName(): ?string;

    public function getIconImage(): ?IconImageInterface;

    /**
     * @return array<array-key, string>
     */
    public function getInstallMetadata(): array;

    public function getLambdaSmartApp(): ?LambdaSmartAppInterface;

    public function getLastUpdatedDate(): ?string;

    public function getOwner(): ?OwnerInterface;

    public function getPrincipalType(): ?string;

    public function getSingleInstance(): ?bool;

    public function getUi(): ?AppUiSettingsInterface;

    public function getWebhookSmartApp(): ?WebhookSmartAppInterface;

    public function setAppId(string $value): self;

    public function setAppName(?string $value): self;

    public function setAppType(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setClassifications(array $value): self;

    public function setCreatedDate(?string $value): self;

    public function setDescription(?string $value): self;

    public function setDisplayName(?string $value): self;

    public function setIconImage(?IconImageInterface $value): self;

    /**
     * @param array<array-key, string> $value
     */
    public function setInstallMetadata(array $value): self;

    public function setLambdaSmartApp(?LambdaSmartAppInterface $value): self;

    public function setLastUpdatedDate(?string $value): self;

    public function setOwner(?OwnerInterface $value): self;

    public function setPrincipalType(?string $value): self;

    public function setSingleInstance(?bool $value): self;

    public function setUi(?AppUiSettingsInterface $value): self;

    public function setWebhookSmartApp(?WebhookSmartAppInterface $value): self;
}
