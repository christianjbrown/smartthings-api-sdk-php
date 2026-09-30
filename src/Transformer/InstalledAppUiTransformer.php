<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppUi;
use ChristianBrown\SmartThings\Model\InstalledAppUiInterface;

use function is_bool;
use function is_string;

final class InstalledAppUiTransformer implements InstalledAppUiTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppUiInterface
    {
        $model = new InstalledAppUi(self::requireDashboardCardsEnabled($data), self::requirePreInstallDashboardCardsEnabled($data));

        self::applyPluginId($model, $data);
        self::applyPluginUri($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPluginId(InstalledAppUi $model, array $data): void
    {
        if (empty($data[self::KEY_PLUGIN_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PLUGIN_ID])) {
            return;
        }
        $model->setPluginId($data[self::KEY_PLUGIN_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPluginUri(InstalledAppUi $model, array $data): void
    {
        if (empty($data[self::KEY_PLUGIN_URI])) {
            return;
        }
        if (!is_string($data[self::KEY_PLUGIN_URI])) {
            return;
        }
        $model->setPluginUri($data[self::KEY_PLUGIN_URI]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDashboardCardsEnabled(array $data): ?bool
    {
        if (!isset($data[self::KEY_DASHBOARD_CARDS_ENABLED])) {
            return null;
        }
        if (!is_bool($data[self::KEY_DASHBOARD_CARDS_ENABLED])) {
            return null;
        }

        return $data[self::KEY_DASHBOARD_CARDS_ENABLED];
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePreInstallDashboardCardsEnabled(array $data): ?bool
    {
        if (!isset($data[self::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED])) {
            return null;
        }
        if (!is_bool($data[self::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED])) {
            return null;
        }

        return $data[self::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED];
    }
}
