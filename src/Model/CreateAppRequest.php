<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateAppRequest implements CreateAppRequestInterface
{
    private string $appName;
    private string $appType;

    /**
     * @var array<int, string>
     */
    private array $classifications;
    private string $description;
    private string $displayName;
    private ?IconImageInterface $iconImage = null;
    private ?CreateOrUpdateLambdaSmartAppRequestInterface $lambdaSmartApp = null;
    private ?AppOauthDefinitionInterface $oauth = null;
    private ?string $principalType = null;
    private ?bool $singleInstance = null;
    private ?AppUiSettingsInterface $ui = null;
    private ?CreateOrUpdateWebhookSmartAppRequestInterface $webhookSmartApp = null;

    /**
     * @phpstan-param array<int, string> $classifications
     */
    public function __construct(string $appName, string $displayName, string $description, string $appType, array $classifications)
    {
        $this->appName = $appName;
        $this->displayName = $displayName;
        $this->description = $description;
        $this->appType = $appType;
        $this->classifications = $classifications;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function getAppType(): string
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getIconImage(): ?IconImageInterface
    {
        return $this->iconImage;
    }

    public function getLambdaSmartApp(): ?CreateOrUpdateLambdaSmartAppRequestInterface
    {
        return $this->lambdaSmartApp;
    }

    public function getOauth(): ?AppOauthDefinitionInterface
    {
        return $this->oauth;
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

    public function getWebhookSmartApp(): ?CreateOrUpdateWebhookSmartAppRequestInterface
    {
        return $this->webhookSmartApp;
    }

    public function setIconImage(?IconImageInterface $value): CreateAppRequestInterface
    {
        $this->iconImage = $value;

        return $this;
    }

    public function setLambdaSmartApp(?CreateOrUpdateLambdaSmartAppRequestInterface $value): CreateAppRequestInterface
    {
        $this->lambdaSmartApp = $value;

        return $this;
    }

    public function setOauth(?AppOauthDefinitionInterface $value): CreateAppRequestInterface
    {
        $this->oauth = $value;

        return $this;
    }

    public function setPrincipalType(?string $value): CreateAppRequestInterface
    {
        $this->principalType = $value;

        return $this;
    }

    public function setSingleInstance(?bool $value): CreateAppRequestInterface
    {
        $this->singleInstance = $value;

        return $this;
    }

    public function setUi(?AppUiSettingsInterface $value): CreateAppRequestInterface
    {
        $this->ui = $value;

        return $this;
    }

    public function setWebhookSmartApp(?CreateOrUpdateWebhookSmartAppRequestInterface $value): CreateAppRequestInterface
    {
        $this->webhookSmartApp = $value;

        return $this;
    }
}
