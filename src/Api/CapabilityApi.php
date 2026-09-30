<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
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
use ChristianBrown\SmartThings\Serializer\CapabilityLocalizationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;

use function array_filter;
use function is_array;
use function rawurlencode;
use function sprintf;

final class CapabilityApi implements CapabilityApiInterface
{
    /**
     * @var array<string, CapabilityInterface>
     */
    private array $cache = [];
    private CapabilitiesTransformerInterface $capabilitiesTransformer;
    private CapabilityLocalizationRequestSerializerInterface $capabilityLocalizationRequestSerializer;
    private CapabilityNamespacesTransformerInterface $capabilityNamespacesTransformer;
    private CapabilityPresentationTransformerInterface $capabilityPresentationTransformer;
    private CapabilityTransformerInterface $capabilityTransformer;
    private CreateCapabilityPresentationRequestSerializerInterface $createCapabilityPresentationRequestSerializer;
    private CreateCapabilityRequestSerializerInterface $createCapabilityRequestSerializer;

    /**
     * @var ?array<int, CapabilityInterface>
     */
    private ?array $listCache = null;
    private LocaleReferencesTransformerInterface $localeReferencesTransformer;

    /**
     * @var array<string, array<int, LocaleReferenceInterface>>
     */
    private array $localesCache = [];
    private LocalizationTransformerInterface $localizationTransformer;

    /**
     * @var array<string, array<int, CapabilityInterface>>
     */
    private array $namespaceCache = [];

    /**
     * @var ?array<int, CapabilityNamespaceInterface>
     */
    private ?array $namespacesCache = null;

    /**
     * @var array<string, CapabilityPresentationInterface>
     */
    private array $presentationCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, LocalizationInterface>
     */
    private array $translationsCache = [];
    private UpdateCapabilityPresentationRequestSerializerInterface $updateCapabilityPresentationRequestSerializer;
    private UpdateCapabilityRequestSerializerInterface $updateCapabilityRequestSerializer;
    private RequestUrlBuilderInterface $urlBuilder;

    /**
     * @var array<string, array<int, CapabilityInterface>>
     */
    private array $versionsCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, CapabilityTransformerInterface $capabilityTransformer, CapabilitiesTransformerInterface $capabilitiesTransformer, CapabilityNamespacesTransformerInterface $capabilityNamespacesTransformer, CapabilityPresentationTransformerInterface $capabilityPresentationTransformer, LocaleReferencesTransformerInterface $localeReferencesTransformer, LocalizationTransformerInterface $localizationTransformer, TokenInterface $token, CreateCapabilityRequestSerializerInterface $createCapabilityRequestSerializer, UpdateCapabilityRequestSerializerInterface $updateCapabilityRequestSerializer, CapabilityLocalizationRequestSerializerInterface $capabilityLocalizationRequestSerializer, CreateCapabilityPresentationRequestSerializerInterface $createCapabilityPresentationRequestSerializer, UpdateCapabilityPresentationRequestSerializerInterface $updateCapabilityPresentationRequestSerializer, RequestUrlBuilderInterface $urlBuilder)
    {
        $this->requestSender = $requestSender;
        $this->capabilityTransformer = $capabilityTransformer;
        $this->capabilitiesTransformer = $capabilitiesTransformer;
        $this->capabilityNamespacesTransformer = $capabilityNamespacesTransformer;
        $this->capabilityPresentationTransformer = $capabilityPresentationTransformer;
        $this->localeReferencesTransformer = $localeReferencesTransformer;
        $this->localizationTransformer = $localizationTransformer;
        $this->token = $token;
        $this->createCapabilityRequestSerializer = $createCapabilityRequestSerializer;
        $this->updateCapabilityRequestSerializer = $updateCapabilityRequestSerializer;
        $this->capabilityLocalizationRequestSerializer = $capabilityLocalizationRequestSerializer;
        $this->createCapabilityPresentationRequestSerializer = $createCapabilityPresentationRequestSerializer;
        $this->updateCapabilityPresentationRequestSerializer = $updateCapabilityPresentationRequestSerializer;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createCapability(CreateCapabilityRequestInterface $request, ?string $namespace = null, ?string $organizationId = null): CapabilityInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $query = array_filter([self::KEY_NAMESPACE => $namespace], static fn (?string $value): bool => null !== $value);
        $body = $this->createCapabilityRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, $query, $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->capabilityTransformer->transform($data);
        $this->listCache = null;
        $this->namespaceCache = [];
        $this->versionsCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createCapabilityLocalization(string $capabilityId, int $capabilityVersion, CapabilityLocalizationRequestInterface $request): LocalizationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LOCALES_SPRINTF, rawurlencode($capabilityId), $capabilityVersion);
        $body = $this->capabilityLocalizationRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->localizationTransformer->transform($data);
        $this->localesCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createCustomCapabilityPresentation(string $capabilityId, int $capabilityVersion, CreateCapabilityPresentationRequestInterface $request, ?string $organizationId = null): CapabilityPresentationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_PRESENTATION_SPRINTF, rawurlencode($capabilityId), $capabilityVersion);
        $body = $this->createCapabilityPresentationRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->capabilityPresentationTransformer->transform($data);
        $this->presentationCache[sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $capabilityVersion)] = $result;

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteCapability(string $capabilityId, int $capabilityVersion, ?string $organizationId = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($capabilityId), $capabilityVersion);
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $capabilityVersion)], $this->presentationCache[sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $capabilityVersion)]);
        $this->localesCache = [];
        $this->translationsCache = [];
        $this->listCache = null;
        $this->namespaceCache = [];
        $this->versionsCache = [];
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, LocaleReferenceInterface>
     */
    public function getLocales(string $capabilityId, int $version, bool $skipCache = false): array
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $version);
        if (!$skipCache) {
            if (isset($this->localesCache[$cacheKey])) {
                return $this->localesCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LOCALES_SPRINTF, rawurlencode($capabilityId), $version);
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $locales = $this->localeReferencesTransformer->transform($data[self::KEY_ITEMS]);
        $this->localesCache[$cacheKey] = $locales;

        return $locales;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    public function getMultiple(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->listCache) {
                return $this->listCache;
            }
        }

        $capabilities = $this->fetchList(self::API_URL);
        $this->listCache = $capabilities;

        return $capabilities;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    public function getMultipleByNamespace(string $namespace, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->namespaceCache[$namespace])) {
                return $this->namespaceCache[$namespace];
            }
        }

        $url = sprintf(self::API_URL_NAMESPACE_SPRINTF, rawurlencode($namespace));
        $capabilities = $this->fetchList($url);
        $this->namespaceCache[$namespace] = $capabilities;

        return $capabilities;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityNamespaceInterface>
     */
    public function getNamespaces(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->namespacesCache) {
                return $this->namespacesCache;
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        // The namespaces endpoint returns a top-level JSON array (no items wrapper),
        // so the whole decoded response is the collection handed to the transformer.
        $data = $this->requestSender->get(self::API_URL_NAMESPACES, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $namespaces = $this->capabilityNamespacesTransformer->transform($data);
        $this->namespacesCache = $namespaces;

        return $namespaces;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByIdAndVersion(string $capabilityId, int $version, bool $skipCache = false): CapabilityInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $version);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($capabilityId), $version);
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $capability = $this->capabilityTransformer->transform($data);
        $this->cache[$cacheKey] = $capability;

        return $capability;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getPresentation(string $capabilityId, int $version, bool $skipCache = false): CapabilityPresentationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $version);
        if (!$skipCache) {
            if (isset($this->presentationCache[$cacheKey])) {
                return $this->presentationCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_PRESENTATION_SPRINTF, rawurlencode($capabilityId), $version);
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $presentation = $this->capabilityPresentationTransformer->transform($data);
        $this->presentationCache[$cacheKey] = $presentation;

        return $presentation;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getTranslations(string $capabilityId, int $version, string $tag, bool $skipCache = false, ?string $presentationId = null, ?string $manufacturerName = null): LocalizationInterface
    {
        $url = $this->urlBuilder->build(sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($capabilityId), $version, rawurlencode($tag)), [self::KEY_PRESENTATION_ID => $presentationId, self::KEY_MANUFACTURER_NAME => $manufacturerName]);
        $cacheKey = $url;
        if (!$skipCache) {
            if (isset($this->translationsCache[$cacheKey])) {
                return $this->translationsCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $localization = $this->localizationTransformer->transform($data);
        $this->translationsCache[$cacheKey] = $localization;

        return $localization;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    public function getVersions(string $capabilityId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->versionsCache[$capabilityId])) {
                return $this->versionsCache[$capabilityId];
            }
        }

        $url = sprintf(self::API_URL_VERSIONS_SPRINTF, rawurlencode($capabilityId));
        $capabilities = $this->fetchList($url);
        $this->versionsCache[$capabilityId] = $capabilities;

        return $capabilities;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function patchCapabilityLocalization(string $capabilityId, int $capabilityVersion, string $locale, CapabilityLocalizationRequestInterface $request): LocalizationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($capabilityId), $capabilityVersion, rawurlencode($locale));
        $body = $this->capabilityLocalizationRequestSerializer->serialize($request);
        $data = $this->requestSender->patch($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->localizationTransformer->transform($data);
        $this->translationsCache[sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($capabilityId), $capabilityVersion, rawurlencode($locale))] = $result;
        $this->localesCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateCapability(string $capabilityId, int $capabilityVersion, UpdateCapabilityRequestInterface $request, ?string $organizationId = null): CapabilityInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($capabilityId), $capabilityVersion);
        $body = $this->updateCapabilityRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->capabilityTransformer->transform($data);
        $this->cache[sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $capabilityVersion)] = $result;
        $this->listCache = null;
        $this->namespaceCache = [];
        $this->versionsCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateCapabilityLocalization(string $capabilityId, int $capabilityVersion, string $locale, CapabilityLocalizationRequestInterface $request): LocalizationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($capabilityId), $capabilityVersion, rawurlencode($locale));
        $body = $this->capabilityLocalizationRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->localizationTransformer->transform($data);
        $this->translationsCache[sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($capabilityId), $capabilityVersion, rawurlencode($locale))] = $result;
        $this->localesCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateCustomCapabilityPresentation(string $capabilityId, int $capabilityVersion, UpdateCapabilityPresentationRequestInterface $request, ?string $organizationId = null): CapabilityPresentationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_PRESENTATION_SPRINTF, rawurlencode($capabilityId), $capabilityVersion);
        $body = $this->updateCapabilityPresentationRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->capabilityPresentationTransformer->transform($data);
        $this->presentationCache[sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $capabilityVersion)] = $result;

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    private function fetchList(string $url): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }

        return $this->capabilitiesTransformer->transform($data[self::KEY_ITEMS]);
    }
}
