<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppDetailsInterface
{
    public function getIconImage(): ?IconImageInterface;

    public function getLambdaSmartApp(): ?LambdaSmartAppInterface;

    public function getOwner(): ?OwnerInterface;

    public function getUi(): ?AppUiSettingsInterface;

    public function getWebhookSmartApp(): ?WebhookSmartAppInterface;

    public function setIconImage(?IconImageInterface $value): self;

    public function setLambdaSmartApp(?LambdaSmartAppInterface $value): self;

    public function setOwner(?OwnerInterface $value): self;

    public function setUi(?AppUiSettingsInterface $value): self;

    public function setWebhookSmartApp(?WebhookSmartAppInterface $value): self;
}
