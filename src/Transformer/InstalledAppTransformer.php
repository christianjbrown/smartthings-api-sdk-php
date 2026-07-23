<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledApp;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;

use function is_string;
use function sprintf;

final class InstalledAppTransformer implements InstalledAppTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppInterface
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_INSTALLED_APP_ID));
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_INSTALLED_APP_ID));
        }
        $installedApp = new InstalledApp($data[self::KEY_INSTALLED_APP_ID]);

        self::applyAppId($installedApp, $data);
        self::applyDisplayName($installedApp, $data);
        self::applyInstalledAppStatus($installedApp, $data);
        self::applyInstalledAppType($installedApp, $data);
        self::applyLocationId($installedApp, $data);

        return $installedApp;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppId(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_ID])) {
            return;
        }
        $installedApp->setAppId($data[self::KEY_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDisplayName(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        $installedApp->setDisplayName($data[self::KEY_DISPLAY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppStatus(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_STATUS])) {
            return;
        }
        $installedApp->setInstalledAppStatus($data[self::KEY_INSTALLED_APP_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppType(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_TYPE])) {
            return;
        }
        $installedApp->setInstalledAppType($data[self::KEY_INSTALLED_APP_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $installedApp->setLocationId($data[self::KEY_LOCATION_ID]);
    }
}
