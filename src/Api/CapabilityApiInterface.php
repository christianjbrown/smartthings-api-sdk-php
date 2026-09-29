<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Model\CapabilityLocalizationRequestInterface;
use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;
use ChristianBrown\SmartThings\Model\CapabilityPresentationInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityRequestInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateCapabilityRequestInterface;

interface CapabilityApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/capabilities';
    public const string API_URL_LOCALES_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s/%s/i18n';
    public const string API_URL_NAMESPACE_SPRINTF = 'https://api.smartthings.com/v1/capabilities/namespaces/%s';
    public const string API_URL_NAMESPACES = 'https://api.smartthings.com/v1/capabilities/namespaces';
    public const string API_URL_PRESENTATION_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s/%s/presentation';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s/%s';
    public const string API_URL_TRANSLATIONS_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s/%s/i18n/%s';
    public const string API_URL_VERSIONS_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%d';
    public const string KEY_ITEMS = 'items';
    public const string KEY_NAMESPACE = 'namespace';
    public const string TRANSLATIONS_CACHE_KEY_SPRINTF = '%s/%d/%s';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a custom capability, optionally in a namespace. The organization id selects the organization the capability is created for. Invalidates the cached capability lists.
     */
    public function createCapability(CreateCapabilityRequestInterface $request, ?string $namespace = null, ?string $organizationId = null): CapabilityInterface;

    /**
     * Creates a localization for a capability version. Invalidates the cached locale lists.
     */
    public function createCapabilityLocalization(string $capabilityId, int $capabilityVersion, CapabilityLocalizationRequestInterface $request): LocalizationInterface;

    /**
     * Creates the presentation of a custom capability. The dashboard, detail view, automation and presentation settings sections are accepted as raw arrays shaped per the vendor schema. Refreshes the cached presentation.
     */
    public function createCustomCapabilityPresentation(string $capabilityId, int $capabilityVersion, CreateCapabilityPresentationRequestInterface $request, ?string $organizationId = null): CapabilityPresentationInterface;

    /**
     * Deletes a custom capability version. Invalidates every cached copy of it and the cached capability lists.
     */
    public function deleteCapability(string $capabilityId, int $capabilityVersion, ?string $organizationId = null): void;

    /**
     * @return array<int, LocaleReferenceInterface>
     */
    public function getLocales(string $capabilityId, int $version, bool $skipCache = false): array;

    /**
     * @return array<int, CapabilityInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    /**
     * @return array<int, CapabilityInterface>
     */
    public function getMultipleByNamespace(string $namespace, bool $skipCache = false): array;

    /**
     * @return array<int, CapabilityNamespaceInterface>
     */
    public function getNamespaces(bool $skipCache = false): array;

    public function getOneByIdAndVersion(string $capabilityId, int $version, bool $skipCache = false): CapabilityInterface;

    public function getPresentation(string $capabilityId, int $version, bool $skipCache = false): CapabilityPresentationInterface;

    public function getTranslations(string $capabilityId, int $version, string $tag, bool $skipCache = false): LocalizationInterface;

    /**
     * @return array<int, CapabilityInterface>
     */
    public function getVersions(string $capabilityId, bool $skipCache = false): array;

    /**
     * Partially updates a localization of a capability version. Refreshes its cached copy and invalidates the cached locale lists.
     */
    public function patchCapabilityLocalization(string $capabilityId, int $capabilityVersion, string $locale, CapabilityLocalizationRequestInterface $request): LocalizationInterface;

    /**
     * Updates a custom capability version. Refreshes its cached copy and invalidates the cached capability lists.
     */
    public function updateCapability(string $capabilityId, int $capabilityVersion, UpdateCapabilityRequestInterface $request, ?string $organizationId = null): CapabilityInterface;

    /**
     * Replaces a localization of a capability version. Refreshes its cached copy and invalidates the cached locale lists.
     */
    public function updateCapabilityLocalization(string $capabilityId, int $capabilityVersion, string $locale, CapabilityLocalizationRequestInterface $request): LocalizationInterface;

    /**
     * Replaces the presentation of a custom capability. Refreshes the cached presentation.
     */
    public function updateCustomCapabilityPresentation(string $capabilityId, int $capabilityVersion, UpdateCapabilityPresentationRequestInterface $request, ?string $organizationId = null): CapabilityPresentationInterface;
}
