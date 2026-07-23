<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfig;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;

use function is_string;
use function sprintf;

final class InstalledAppConfigTransformer implements InstalledAppConfigTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppConfigInterface
    {
        if (empty($data[self::KEY_CONFIGURATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CONFIGURATION_ID));
        }
        if (!is_string($data[self::KEY_CONFIGURATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CONFIGURATION_ID));
        }
        $config = new InstalledAppConfig($data[self::KEY_CONFIGURATION_ID]);

        self::applyConfigurationStatus($config, $data);
        self::applyInstalledAppId($config, $data);

        return $config;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConfigurationStatus(InstalledAppConfig $config, array $data): void
    {
        if (empty($data[self::KEY_CONFIGURATION_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_CONFIGURATION_STATUS])) {
            return;
        }
        $config->setConfigurationStatus($data[self::KEY_CONFIGURATION_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppId(InstalledAppConfig $config, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        $config->setInstalledAppId($data[self::KEY_INSTALLED_APP_ID]);
    }
}
