<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateAppRequest implements UpdateAppRequestInterface
{
    private string $appType;

    /**
     * @var array<int, string>
     */
    private array $classifications;
    private string $description;
    private string $displayName;
    private ?IconImageInterface $iconImage = null;
    private ?CreateOrUpdateLambdaSmartAppRequestInterface $lambdaSmartApp = null;
    private ?bool $singleInstance = null;
    private ?AppUiSettingsInterface $ui = null;
    private ?CreateOrUpdateWebhookSmartAppRequestInterface $webhookSmartApp = null;

    /**
     * @phpstan-param array<int, string> $classifications
     */
    public function __construct(string $displayName, string $description, string $appType, array $classifications)
    {
        $this->displayName = $displayName;
        $this->description = $description;
        $this->appType = $appType;
        $this->classifications = $classifications;
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

    public function setIconImage(?IconImageInterface $value): UpdateAppRequestInterface
    {
        $this->iconImage = $value;

        return $this;
    }

    public function setLambdaSmartApp(?CreateOrUpdateLambdaSmartAppRequestInterface $value): UpdateAppRequestInterface
    {
        $this->lambdaSmartApp = $value;

        return $this;
    }

    public function setSingleInstance(?bool $value): UpdateAppRequestInterface
    {
        $this->singleInstance = $value;

        return $this;
    }

    public function setUi(?AppUiSettingsInterface $value): UpdateAppRequestInterface
    {
        $this->ui = $value;

        return $this;
    }

    public function setWebhookSmartApp(?CreateOrUpdateWebhookSmartAppRequestInterface $value): UpdateAppRequestInterface
    {
        $this->webhookSmartApp = $value;

        return $this;
    }
}
