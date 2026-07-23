<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaPageInterface;

interface SchemaConnectorApiInterface extends ApiInterface
{
    public const string API_URL_APP_SPRINTF = 'https://api.smartthings.com/v1/schema/apps/%s';
    public const string API_URL_APPS = 'https://api.smartthings.com/v1/schema/apps';
    public const string API_URL_INSTALL_SPRINTF = 'https://api.smartthings.com/v1/schema/install/%s';
    public const string API_URL_INSTALLED_APP_SPRINTF = 'https://api.smartthings.com/v1/schema/installedapps/%s';
    public const string API_URL_INSTALLED_APPS_LOCATION_SPRINTF = 'https://api.smartthings.com/v1/schema/installedapps/location/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ENDPOINT_APPS = 'endpointApps';
    public const string KEY_INSTALLED_SMART_APPS = 'installedSmartApps';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_TYPE = 'type';
    public const string TYPE_OAUTH_LINK = 'oauthLink';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    public function getInstalledById(string $isaId, bool $skipCache = false): InstalledSchemaAppInterface;

    /**
     * @return array<int, InstalledSchemaAppInterface>
     */
    public function getInstalledMultiple(string $locationId, bool $skipCache = false): array;

    public function getInstallPage(string $endpointAppId, string $locationId, bool $skipCache = false): SchemaPageInterface;

    /**
     * @return array<int, SchemaAppInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $endpointAppId, bool $skipCache = false): SchemaAppInterface;
}
