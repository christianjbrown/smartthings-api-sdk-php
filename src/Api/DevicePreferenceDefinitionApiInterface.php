<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\PreferenceListQueryInterface;
use ChristianBrown\SmartThings\Model\PreferenceLocalizationRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;

interface DevicePreferenceDefinitionApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/devicepreferences';
    public const string API_URL_LOCALES_SPRINTF = 'https://api.smartthings.com/v1/devicepreferences/%s/i18n';
    public const string API_URL_PREFERENCE_LOCALIZATION_SPRINTF = 'https://api.smartthings.com/v1/preferences/%s/i18n/%s';
    public const string API_URL_PREFERENCE_LOCALIZATIONS_SPRINTF = 'https://api.smartthings.com/v1/preferences/%s/i18n';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/devicepreferences/%s';
    public const string API_URL_TRANSLATIONS_SPRINTF = 'https://api.smartthings.com/v1/devicepreferences/%s/i18n/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_NAMESPACE = 'namespace';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a Preference. Invalidates the cached preference lists so a subsequent
     * getMultiple() reflects the new preference.
     */
    public function createPreference(PreferenceRequestInterface $request): DevicePreferenceDefinitionInterface;

    /**
     * Creates a localization for a preference. Invalidates the cached locale list of the preference.
     */
    public function createPreferenceLocalization(string $preferenceId, PreferenceLocalizationRequestInterface $request): LocalizationInterface;

    /**
     * Deletes a Preference by id. Invalidates any cached copy of this preference and
     * the cached preference lists.
     */
    public function deletePreferenceById(string $preferenceId): void;

    /**
     * @return array<int, LocaleReferenceInterface>
     */
    public function getLocales(string $preferenceId, bool $skipCache = false): array;

    /**
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function getMultiple(?string $namespace = null, bool $skipCache = false, ?PreferenceListQueryInterface $query = null): array;

    public function getOneById(string $preferenceId, bool $skipCache = false): DevicePreferenceDefinitionInterface;

    public function getTranslations(string $preferenceId, string $locale, bool $skipCache = false): LocalizationInterface;

    /**
     * Updates a Preference by id. Refreshes the cached copy of this preference and
     * invalidates the cached preference lists.
     */
    public function updatePreferenceById(string $preferenceId, PreferenceRequestInterface $request): DevicePreferenceDefinitionInterface;

    /**
     * Replaces a localization of a preference. Invalidates the cached translations and the cached locale list of the preference.
     */
    public function updatePreferenceLocalization(string $preferenceId, string $locale, PreferenceLocalizationRequestInterface $request): LocalizationInterface;
}
