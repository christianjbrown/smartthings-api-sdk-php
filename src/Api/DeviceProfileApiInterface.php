<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;

interface DeviceProfileApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/deviceprofiles';
    public const string API_URL_LOCALES_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s/i18n';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s';
    public const string API_URL_TRANSLATIONS_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s/i18n/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, LocaleReferenceInterface>
     */
    public function getLocales(string $deviceProfileId, bool $skipCache = false): array;

    /**
     * @return array<int, DeviceProfileInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $deviceProfileId, bool $skipCache = false): DeviceProfileInterface;

    public function getTranslations(string $deviceProfileId, string $tag, bool $skipCache = false): LocalizationInterface;
}
