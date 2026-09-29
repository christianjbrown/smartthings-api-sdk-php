<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class App implements AppInterface
{
    private string $appId;
    private ?string $appName = null;
    private ?string $appType = null;

    /**
     * @var array<int, string>
     */
    private array $classifications = [];
    private ?string $createdDate = null;
    private ?string $description = null;
    private ?string $displayName = null;
    private ?IconImageInterface $iconImage = null;

    /**
     * @var array<array-key, string>
     */
    private array $installMetadata = [];
    private ?LambdaSmartAppInterface $lambdaSmartApp = null;
    private ?string $lastUpdatedDate = null;
    private ?OwnerInterface $owner = null;
    private ?string $principalType = null;
    private ?bool $singleInstance = null;
    private ?AppUiSettingsInterface $ui = null;
    private ?WebhookSmartAppInterface $webhookSmartApp = null;

    public function __construct(string $appId)
    {
        $this->appId = $appId;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function getAppType(): ?string
    {
        return $this->appType;
    }

    /**
     * @return array<int, string>
     */
    public function getClassifications(): array
    {
        return $this->classifications;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function getIconImage(): ?IconImageInterface
    {
        return $this->iconImage;
    }

    /**
     * @return array<array-key, string>
     */
    public function getInstallMetadata(): array
    {
        return $this->installMetadata;
    }

    public function getLambdaSmartApp(): ?LambdaSmartAppInterface
    {
        return $this->lambdaSmartApp;
    }

    public function getLastUpdatedDate(): ?string
    {
        return $this->lastUpdatedDate;
    }

    public function getOwner(): ?OwnerInterface
    {
        return $this->owner;
    }

    public function getPrincipalType(): ?string
    {
        return $this->principalType;
    }

    public function getSingleInstance(): ?bool
    {
        return $this->singleInstance;
    }

    public function getUi(): ?AppUiSettingsInterface
    {
        return $this->ui;
    }

    public function getWebhookSmartApp(): ?WebhookSmartAppInterface
    {
        return $this->webhookSmartApp;
    }

    public function setAppId(string $value): AppInterface
    {
        $this->appId = $value;

        return $this;
    }

    public function setAppName(?string $value): AppInterface
    {
        $this->appName = $value;

        return $this;
    }

    public function setAppType(?string $value): AppInterface
    {
        $this->appType = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setClassifications(array $value): AppInterface
    {
        $this->classifications = $value;

        return $this;
    }

    public function setCreatedDate(?string $value): AppInterface
    {
        $this->createdDate = $value;

        return $this;
    }

    public function setDescription(?string $value): AppInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setDisplayName(?string $value): AppInterface
    {
        $this->displayName = $value;

        return $this;
    }

    public function setIconImage(?IconImageInterface $value): AppInterface
    {
        $this->iconImage = $value;

        return $this;
    }

    /**
     * @param array<array-key, string> $value
     */
    public function setInstallMetadata(array $value): AppInterface
    {
        $this->installMetadata = $value;

        return $this;
    }

    public function setLambdaSmartApp(?LambdaSmartAppInterface $value): AppInterface
    {
        $this->lambdaSmartApp = $value;

        return $this;
    }

    public function setLastUpdatedDate(?string $value): AppInterface
    {
        $this->lastUpdatedDate = $value;

        return $this;
    }

    public function setOwner(?OwnerInterface $value): AppInterface
    {
        $this->owner = $value;

        return $this;
    }

    public function setPrincipalType(?string $value): AppInterface
    {
        $this->principalType = $value;

        return $this;
    }

    public function setSingleInstance(?bool $value): AppInterface
    {
        $this->singleInstance = $value;

        return $this;
    }

    public function setUi(?AppUiSettingsInterface $value): AppInterface
    {
        $this->ui = $value;

        return $this;
    }

    public function setWebhookSmartApp(?WebhookSmartAppInterface $value): AppInterface
    {
        $this->webhookSmartApp = $value;

        return $this;
    }
}
