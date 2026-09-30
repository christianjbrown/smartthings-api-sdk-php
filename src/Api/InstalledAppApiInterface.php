<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\CoordinateAliasRequestInterface;
use ChristianBrown\SmartThings\Model\CreateInstalledAppEventsRequestInterface;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;
use ChristianBrown\SmartThings\Model\InstalledAppListQueryInterface;

interface InstalledAppApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/installedapps';
    public const string API_URL_ALIAS_CAPABILITY_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/alias/%s/capability';
    public const string API_URL_ALIAS_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/alias/%s';
    public const string API_URL_CONFIG_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/configs/%s';
    public const string API_URL_CONFIGS_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/configs';
    public const string API_URL_EVENTS_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/events';
    public const string API_URL_ME = 'https://api.smartthings.com/v1/installedapps/me';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_CONFIGURATION_STATUS = 'configurationStatus';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Sends SmartApp events and dashboard card events to the clients of an installed app.
     */
    public function createEvents(string $installedAppId, CreateInstalledAppEventsRequestInterface $request): void;

    /**
     * Deletes a named set of coordinates from an installed app.
     */
    public function deleteCoordinateAlias(string $installedAppId, string $aliasName): void;

    /**
     * Deletes an installed app. Invalidates every cached copy of it, its configurations and the cached installed app lists.
     */
    public function deleteInstallation(string $installedAppId): void;

    public function getConfig(string $installedAppId, string $configurationId, bool $skipCache = false): InstalledAppConfigInterface;

    /**
     * @return array<int, InstalledAppConfigInterface>
     */
    public function getConfigs(string $installedAppId, bool $skipCache = false, ?string $configurationStatus = null): array;

    /**
     * Reads the named capabilities (comma-separated, for example weather,airQuality) for a coordinate alias, as the raw decoded response.
     *
     * @return mixed[]
     */
    public function getCoordinateAliasCapability(string $installedAppId, string $aliasName, string $name): array;

    public function getMe(bool $skipCache = false): InstalledAppInterface;

    /**
     * @return array<int, InstalledAppInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false, ?InstalledAppListQueryInterface $query = null): array;

    public function getOneById(string $installedAppId, bool $skipCache = false, ?bool $allowed = null): InstalledAppInterface;

    /**
     * Creates or replaces a named set of coordinates for an installed app.
     */
    public function putCoordinateAlias(string $installedAppId, string $aliasName, CoordinateAliasRequestInterface $request): void;
}
