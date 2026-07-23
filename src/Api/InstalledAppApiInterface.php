<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;

interface InstalledAppApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/installedapps';
    public const string API_URL_CONFIG_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/configs/%s';
    public const string API_URL_CONFIGS_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/configs';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    public function getConfig(string $installedAppId, string $configurationId, bool $skipCache = false): InstalledAppConfigInterface;

    /**
     * @return array<int, InstalledAppConfigInterface>
     */
    public function getConfigs(string $installedAppId, bool $skipCache = false): array;

    /**
     * @return array<int, InstalledAppInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array;

    public function getOneById(string $installedAppId, bool $skipCache = false): InstalledAppInterface;
}
