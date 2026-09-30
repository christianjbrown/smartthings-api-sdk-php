<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfig;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;

use function is_array;
use function is_string;
use function sprintf;

final class InstalledAppConfigTransformer implements InstalledAppConfigTransformerInterface
{
    private ConfigEntriesTransformerInterface $configEntriesTransformer;
    private ValueReaderInterface $valueReader;

    public function __construct(ConfigEntriesTransformerInterface $configEntriesTransformer, ValueReaderInterface $valueReader)
    {
        $this->configEntriesTransformer = $configEntriesTransformer;
        $this->valueReader = $valueReader;
    }

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

        self::applyConfig($config, $data);
        $config->setConfigEntries($this->configEntriesTransformer->transform($this->valueReader->record($data, self::KEY_CONFIG) ?? []));
        self::applyCreatedDate($config, $data);
        self::applyLastUpdatedDate($config, $data);

        return $config;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConfig(InstalledAppConfig $model, array $data): void
    {
        if (!isset($data[self::KEY_CONFIG])) {
            return;
        }
        if (!is_array($data[self::KEY_CONFIG])) {
            return;
        }
        $model->setConfig($data[self::KEY_CONFIG]);
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
    private static function applyCreatedDate(InstalledAppConfig $model, array $data): void
    {
        if (empty($data[self::KEY_CREATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATED_DATE])) {
            return;
        }
        $model->setCreatedDate($data[self::KEY_CREATED_DATE]);
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

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastUpdatedDate(InstalledAppConfig $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        $model->setLastUpdatedDate($data[self::KEY_LAST_UPDATED_DATE]);
    }
}
