<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledAppUi implements InstalledAppUiInterface
{
    private ?bool $dashboardCardsEnabled;
    private ?string $pluginId = null;
    private ?string $pluginUri = null;
    private ?bool $preInstallDashboardCardsEnabled;

    public function __construct(?bool $dashboardCardsEnabled, ?bool $preInstallDashboardCardsEnabled)
    {
        $this->dashboardCardsEnabled = $dashboardCardsEnabled;
        $this->preInstallDashboardCardsEnabled = $preInstallDashboardCardsEnabled;
    }

    public function getDashboardCardsEnabled(): ?bool
    {
        return $this->dashboardCardsEnabled;
    }

    public function getPluginId(): ?string
    {
        return $this->pluginId;
    }

    public function getPluginUri(): ?string
    {
        return $this->pluginUri;
    }

    public function getPreInstallDashboardCardsEnabled(): ?bool
    {
        return $this->preInstallDashboardCardsEnabled;
    }

    public function setPluginId(?string $value): InstalledAppUiInterface
    {
        $this->pluginId = $value;

        return $this;
    }

    public function setPluginUri(?string $value): InstalledAppUiInterface
    {
        $this->pluginUri = $value;

        return $this;
    }
}
