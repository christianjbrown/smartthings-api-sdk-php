<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppCreateRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppReceiptInterface;
use ChristianBrown\SmartThings\Model\SchemaAppUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaOauthCredentialsRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaPageInterface;

interface SchemaConnectorApiInterface extends ApiInterface
{
    public const string API_URL_APP_SPRINTF = 'https://api.smartthings.com/v1/schema/apps/%s';
    public const string API_URL_APPS = 'https://api.smartthings.com/v1/schema/apps';
    public const string API_URL_INSTALL_SPRINTF = 'https://api.smartthings.com/v1/schema/install/%s';
    public const string API_URL_INSTALLED_APP_SPRINTF = 'https://api.smartthings.com/v1/schema/installedapps/%s';
    public const string API_URL_INSTALLED_APPS_LOCATION_SPRINTF = 'https://api.smartthings.com/v1/schema/installedapps/location/%s';
    public const string API_URL_OAUTH_CREDENTIALS = 'https://api.smartthings.com/v1/schema/oauth/stclient/credentials';
    public const string API_URL_ORGANIZATION_APPS = 'https://api.smartthings.com/v1/schema/apps/organizations';
    public const string API_URL_USER_APPS_SPRINTF = 'https://api.smartthings.com/v1/schema/apps/user/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ENDPOINT_APPS = 'endpointApps';
    public const string KEY_INSTALLED_SMART_APPS = 'installedSmartApps';
    public const string KEY_JSON_RSP_REQUESTED = 'jsonRspRequested';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_REDIRECT_REQUESTED = 'redirectRequested';
    public const string KEY_TYPE = 'type';
    public const string TYPE_OAUTH_LINK = 'oauthLink';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a schema (Cloud-to-Cloud) app. The receipt carries the generated SmartThings client id and secret. Invalidates the cached app list.
     */
    public function createApp(SchemaAppCreateRequestInterface $request, ?string $organizationId = null): SchemaAppReceiptInterface;

    /**
     * Deletes a schema app. Invalidates the cached copy of the app and the cached app list.
     */
    public function deleteApp(string $endpointAppId, ?string $organizationId = null): void;

    /**
     * Deletes an installed schema app. Invalidates the cached copy and the cached installed schema app lists.
     */
    public function deleteInstalled(string $isaId): void;

    /**
     * Generates new SmartThings OAuth client credentials for a schema app.
     */
    public function generateStOauthCredentials(SchemaOauthCredentialsRequestInterface $request, ?string $organizationId = null): SchemaAppReceiptInterface;

    /**
     * Lists the schema apps of an organization.
     *
     * @return array<int, SchemaAppInterface>
     */
    public function getByOrganization(?string $organizationId = null, bool $skipCache = false): array;

    /**
     * Lists the schema apps owned by a user.
     *
     * @return array<int, SchemaAppInterface>
     */
    public function getByUserId(string $userId, bool $skipCache = false): array;

    public function getInstalledById(string $isaId, bool $skipCache = false, ?bool $redirectRequested = null, ?bool $jsonRspRequested = null): InstalledSchemaAppInterface;

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

    /**
     * Replaces a schema app. Invalidates the cached copy of the app and the cached app list.
     */
    public function updateApp(string $endpointAppId, SchemaAppUpdateRequestInterface $request, ?string $organizationId = null): void;
}
