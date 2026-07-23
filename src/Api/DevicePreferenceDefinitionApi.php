<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
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
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, LocalizationInterface>
     */
    private array $translationsCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer, DevicePreferenceDefinitionsTransformerInterface $devicePreferenceDefinitionsTransformer, LocaleReferencesTransformerInterface $localeReferencesTransformer, LocalizationTransformerInterface $localizationTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->devicePreferenceDefinitionTransformer = $devicePreferenceDefinitionTransformer;
        $this->devicePreferenceDefinitionsTransformer = $devicePreferenceDefinitionsTransformer;
        $this->localeReferencesTransformer = $localeReferencesTransformer;
        $this->localizationTransformer = $localizationTransformer;
        $this->token = $token;
    }

    /**
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
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function getMultiple(?string $namespace = null, bool $skipCache = false): array
    {
        // Cache per namespace; casting keeps null and a real namespace as distinct
        // string keys without adding a null-coalescing branch to this method.
        $cacheKey = (string) $namespace;
        if (!$skipCache) {
            if (isset($this->listCache[$cacheKey])) {
                return $this->listCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(self::API_URL, self::buildQuery($namespace), $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $definitions = $this->devicePreferenceDefinitionsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$cacheKey] = $definitions;

        return $definitions;
    }

    /**
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
     * @return array<string, string>
     */
    private static function buildQuery(?string $namespace): array
    {
        // Isolated so the optional filter is its own path, not multiplied
        // against the cache and response-shape guards in getMultiple().
        if (null === $namespace) {
            return [];
        }

        return [self::KEY_NAMESPACE => $namespace];
    }
}
