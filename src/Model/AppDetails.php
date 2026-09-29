<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AppDetails implements AppDetailsInterface
{
    private ?IconImageInterface $iconImage = null;
    private ?LambdaSmartAppInterface $lambdaSmartApp = null;
    private ?OwnerInterface $owner = null;
    private ?AppUiSettingsInterface $ui = null;
    private ?WebhookSmartAppInterface $webhookSmartApp = null;

    public function getIconImage(): ?IconImageInterface
    {
        return $this->iconImage;
    }

    public function getLambdaSmartApp(): ?LambdaSmartAppInterface
    {
        return $this->lambdaSmartApp;
    }

    public function getOwner(): ?OwnerInterface
    {
        return $this->owner;
    }

    public function getUi(): ?AppUiSettingsInterface
    {
        return $this->ui;
    }

    public function getWebhookSmartApp(): ?WebhookSmartAppInterface
    {
        return $this->webhookSmartApp;
    }

    public function setIconImage(?IconImageInterface $value): AppDetailsInterface
    {
        $this->iconImage = $value;

        return $this;
    }

    public function setLambdaSmartApp(?LambdaSmartAppInterface $value): AppDetailsInterface
    {
        $this->lambdaSmartApp = $value;

        return $this;
    }

    public function setOwner(?OwnerInterface $value): AppDetailsInterface
    {
        $this->owner = $value;

        return $this;
    }

    public function setUi(?AppUiSettingsInterface $value): AppDetailsInterface
    {
        $this->ui = $value;

        return $this;
    }

    public function setWebhookSmartApp(?WebhookSmartAppInterface $value): AppDetailsInterface
    {
        $this->webhookSmartApp = $value;

        return $this;
    }
}
