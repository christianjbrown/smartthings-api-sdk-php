<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequestInterface;

interface DeviceProfileApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/deviceprofiles';
    public const string API_URL_LOCALES_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s/i18n';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s';
    public const string API_URL_TRANSLATIONS_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s/i18n/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_PROFILE_ID = 'profileId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a Device Profile. Invalidates the cached profile list so a subsequent
     * getMultiple() reflects the new profile.
     */
    public function createDeviceProfile(CreateDeviceProfileRequestInterface $request): DeviceProfileInterface;

    /**
     * Deletes a Device Profile by id. Invalidates any cached copy of this profile and
     * the cached profile list.
     */
    public function deleteDeviceProfile(string $deviceProfileId): void;

    /**
     * @return array<int, LocaleReferenceInterface>
     */
    public function getLocales(string $deviceProfileId, bool $skipCache = false): array;

    /**
     * @param bool                    $skipCache  Fetch again instead of using the cached list
     * @param null|array<int, string> $profileIds
     *
     * @return array<int, DeviceProfileInterface>
     */
    public function getMultiple(bool $skipCache = false, ?array $profileIds = null): array;

    public function getOneById(string $deviceProfileId, bool $skipCache = false): DeviceProfileInterface;

    public function getTranslations(string $deviceProfileId, string $tag, bool $skipCache = false): LocalizationInterface;

    /**
     * Updates a currently deployed Device Profile. Refreshes the cached copy of this
     * profile and invalidates the cached profile list.
     */
    public function updateDeviceProfile(string $deviceProfileId, UpdateDeviceProfileRequestInterface $request): DeviceProfileInterface;
}
