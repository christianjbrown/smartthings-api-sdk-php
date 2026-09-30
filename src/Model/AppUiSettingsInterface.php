<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppUiSettingsInterface
{
    public function getDashboardCardsEnabled(): ?bool;

    public function getPluginId(): ?string;

    public function getPluginUri(): ?string;

    public function getPreInstallDashboardCardsEnabled(): ?bool;

    public function setPluginId(?string $value): self;

    public function setPluginUri(?string $value): self;
}
