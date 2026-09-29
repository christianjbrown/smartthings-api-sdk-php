<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppUiSettingsInterface;

interface AppUiSettingsTransformerInterface
{
    public const string KEY_DASHBOARD_CARDS_ENABLED = 'dashboardCardsEnabled';
    public const string KEY_PLUGIN_ID = 'pluginId';
    public const string KEY_PLUGIN_URI = 'pluginUri';
    public const string KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED = 'preInstallDashboardCardsEnabled';
    public const string UNEXPECTED_BOOL_SPRINTF = '%s not set or not a boolean';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppUiSettingsInterface;
}
