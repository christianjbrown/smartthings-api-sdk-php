<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\PreferenceListQueryInterface;
use ChristianBrown\SmartThings\Model\PreferenceLocalizationRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceLocalizationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class DevicePreferenceDefinitionApi implements DevicePreferenceDefinitionApiInterface
{
    /**
     * @var array<string, DevicePreferenceDefinitionInterface>
     */
    private array $cache = [];
    private DevicePreferenceDefinitionsTransformerInterface $devicePreferenceDefinitionsTransformer;
    private DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer;

    /**
     * @var array<string, array<int, DevicePreferenceDefinitionInterface>>
     */
    private array $listCache = [];
    private LocaleReferencesTransformerInterface $localeReferencesTransformer;

    /**
     * @var array<string, array<int, LocaleReferenceInterface>>
     */
    private array $localesCache = [];
    private LocalizationTransformerInterface $localizationTransformer;
    private PreferenceLocalizationRequestSerializerInterface $preferenceLocalizationRequestSerializer;
    private PreferenceRequestSerializerInterface $preferenceRequestSerializer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, LocalizationInterface>
     */
    private array $translationsCache = [];
    private RequestUrlBuilderInterface $urlBuilder;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer, DevicePreferenceDefinitionsTransformerInterface $devicePreferenceDefinitionsTransformer, LocaleReferencesTransformerInterface $localeReferencesTransformer, LocalizationTransformerInterface $localizationTransformer, TokenInterface $token, PreferenceRequestSerializerInterface $preferenceRequestSerializer, PreferenceLocalizationRequestSerializerInterface $preferenceLocalizationRequestSerializer, RequestUrlBuilderInterface $urlBuilder)
    {
        $this->requestSender = $requestSender;
        $this->devicePreferenceDefinitionTransformer = $devicePreferenceDefinitionTransformer;
        $this->devicePreferenceDefinitionsTransformer = $devicePreferenceDefinitionsTransformer;
        $this->localeReferencesTransformer = $localeReferencesTransformer;
        $this->localizationTransformer = $localizationTransformer;
        $this->token = $token;
        $this->preferenceRequestSerializer = $preferenceRequestSerializer;
        $this->preferenceLocalizationRequestSerializer = $preferenceLocalizationRequestSerializer;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createPreference(PreferenceRequestInterface $request, ?string $organizationId = null): DevicePreferenceDefinitionInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $body = $this->preferenceRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $definition = $this->devicePreferenceDefinitionTransformer->transform($data);
        $this->listCache = [];

        return $definition;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createPreferenceLocalization(string $preferenceId, PreferenceLocalizationRequestInterface $request): LocalizationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_PREFERENCE_LOCALIZATIONS_SPRINTF, rawurlencode($preferenceId));
        $body = $this->preferenceLocalizationRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->localizationTransformer->transform($data);
        unset($this->localesCache[$preferenceId]);

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deletePreferenceById(string $preferenceId, ?string $organizationId = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($preferenceId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$preferenceId]);
        $this->listCache = [];
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, LocaleReferenceInterface>
     */
    public function getLocales(string $preferenceId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->localesCache[$preferenceId])) {
                return $this->localesCache[$preferenceId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LOCALES_SPRINTF, rawurlencode($preferenceId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $locales = $this->localeReferencesTransformer->transform($data[self::KEY_ITEMS]);
        $this->localesCache[$preferenceId] = $locales;

        return $locales;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function getMultiple(?string $namespace = null, bool $skipCache = false, ?PreferenceListQueryInterface $query = null): array
    {
        // The full URL, query included, identifies the request, so it keys the cache.
        $url = $this->urlBuilder->build(self::API_URL, [self::KEY_NAMESPACE => $namespace], $query);
        if (!$skipCache) {
            if (isset($this->listCache[$url])) {
                return $this->listCache[$url];
            }
        }

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
        $definitions = $this->devicePreferenceDefinitionsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$url] = $definitions;

        return $definitions;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $preferenceId, bool $skipCache = false): DevicePreferenceDefinitionInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$preferenceId])) {
                return $this->cache[$preferenceId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($preferenceId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $definition = $this->devicePreferenceDefinitionTransformer->transform($data);
        $this->cache[$preferenceId] = $definition;

        return $definition;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getTranslations(string $preferenceId, string $locale, bool $skipCache = false): LocalizationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $preferenceId, $locale);
        if (!$skipCache) {
            if (isset($this->translationsCache[$cacheKey])) {
                return $this->translationsCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($preferenceId), rawurlencode($locale));
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
     */
    public function updatePreferenceById(string $preferenceId, PreferenceRequestInterface $request, ?string $organizationId = null): DevicePreferenceDefinitionInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($preferenceId));
        $body = $this->preferenceRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $definition = $this->devicePreferenceDefinitionTransformer->transform($data);
        $this->cache[$preferenceId] = $definition;
        $this->listCache = [];

        return $definition;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updatePreferenceLocalization(string $preferenceId, string $locale, PreferenceLocalizationRequestInterface $request): LocalizationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_PREFERENCE_LOCALIZATION_SPRINTF, rawurlencode($preferenceId), rawurlencode($locale));
        $body = $this->preferenceLocalizationRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->localizationTransformer->transform($data);
        $this->translationsCache = [];
        unset($this->localesCache[$preferenceId]);

        return $result;
    }
}
