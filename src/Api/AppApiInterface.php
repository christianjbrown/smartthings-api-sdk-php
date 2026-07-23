<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;

interface AppApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/apps';
    public const string API_URL_OAUTH_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/oauth';
    public const string API_URL_SETTINGS_SPRINTF = 'https://api.smartthings.com/v1/apps/%s/settings';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/apps/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, AppInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOauth(string $appNameOrId, bool $skipCache = false): AppOauthInterface;

    public function getOneById(string $appNameOrId, bool $skipCache = false): AppInterface;

    public function getSettings(string $appNameOrId, bool $skipCache = false): AppSettingsInterface;
}
