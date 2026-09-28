<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;
use ChristianBrown\SmartThings\Model\CreateAppRequestInterface;
use ChristianBrown\SmartThings\Model\CreateAppResponseInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthRequestInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthResponseInterface;
use ChristianBrown\SmartThings\Model\UpdateAppOauthRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateAppRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateAppSettingsRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateSignatureTypeRequestInterface;

interface AppApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/apps';
    public const string API_URL_OAUTH_GENERATE_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/oauth/generate';
    public const string API_URL_OAUTH_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/oauth';
    public const string API_URL_REGISTER_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/register';
    public const string API_URL_SETTINGS_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/settings';
    public const string API_URL_SIGNATURE_TYPE_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/signature-type';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/apps/%s';
    public const string KEY_ACCOUNT_ID = 'accountId';
    public const string KEY_ITEMS = 'items';
    public const string KEY_REQUIRE_CONFIRMATION = 'requireConfirmation';
    public const string KEY_SIGNATURE_TYPE = 'signatureType';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates an app. The response carries the app and, when OAuth was requested, the generated client id and secret. Invalidates the cached app list.
     */
    public function createApp(CreateAppRequestInterface $request, ?string $signatureType = null, ?bool $requireConfirmation = null, ?string $accountId = null): CreateAppResponseInterface;

    /**
     * Deletes an app. Invalidates every cached copy of it and the cached app list.
     */
    public function deleteApp(string $appNameOrId): void;

    /**
     * Generates a new OAuth client id and secret for an app. Invalidates the cached OAuth settings.
     */
    public function generateAppOauth(string $appNameOrId, GenerateAppOauthRequestInterface $request): GenerateAppOauthResponseInterface;

    /**
     * @return array<int, AppInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOauth(string $appNameOrId, bool $skipCache = false): AppOauthInterface;

    public function getOneById(string $appNameOrId, bool $skipCache = false): AppInterface;

    public function getSettings(string $appNameOrId, bool $skipCache = false): AppSettingsInterface;

    /**
     * Asks SmartThings to confirm the webhook target URL of an app. Invalidates the cached copy of the app.
     */
    public function register(string $appNameOrId): void;

    /**
     * Updates an app. Refreshes the cached copy of the app and invalidates the cached app list.
     */
    public function updateApp(string $appNameOrId, UpdateAppRequestInterface $request, ?string $signatureType = null, ?bool $requireConfirmation = null): AppInterface;

    /**
     * Replaces the OAuth settings of an app. Refreshes the cached OAuth settings.
     */
    public function updateAppOauth(string $appNameOrId, UpdateAppOauthRequestInterface $request): AppOauthInterface;

    /**
     * Replaces the settings of an app. Refreshes the cached settings.
     */
    public function updateAppSettings(string $appNameOrId, UpdateAppSettingsRequestInterface $request): AppSettingsInterface;

    /**
     * Changes the request signature type of a webhook app. Invalidates the cached copy of the app.
     */
    public function updateSignatureType(string $appNameOrId, UpdateSignatureTypeRequestInterface $request): void;
}
