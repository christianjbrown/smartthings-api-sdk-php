<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class DeviceProfileApi implements DeviceProfileApiInterface
{
    /**
     * @var array<string, DeviceProfileInterface>
     */
    private array $cache = [];
    private DeviceProfilesTransformerInterface $deviceProfilesTransformer;
    private DeviceProfileTransformerInterface $deviceProfileTransformer;

    /**
     * @var ?array<int, DeviceProfileInterface>
     */
    private ?array $listCache = null;
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

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceProfileTransformerInterface $deviceProfileTransformer, DeviceProfilesTransformerInterface $deviceProfilesTransformer, LocaleReferencesTransformerInterface $localeReferencesTransformer, LocalizationTransformerInterface $localizationTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->deviceProfileTransformer = $deviceProfileTransformer;
        $this->deviceProfilesTransformer = $deviceProfilesTransformer;
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
    public function getLocales(string $deviceProfileId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->localesCache[$deviceProfileId])) {
                return $this->localesCache[$deviceProfileId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LOCALES_SPRINTF, rawurlencode($deviceProfileId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $locales = $this->localeReferencesTransformer->transform($data[self::KEY_ITEMS]);
        $this->localesCache[$deviceProfileId] = $locales;

        return $locales;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceProfileInterface>
     */
    public function getMultiple(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->listCache) {
                return $this->listCache;
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(self::API_URL, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $profiles = $this->deviceProfilesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache = $profiles;

        return $profiles;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $deviceProfileId, bool $skipCache = false): DeviceProfileInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$deviceProfileId])) {
                return $this->cache[$deviceProfileId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceProfileId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $profile = $this->deviceProfileTransformer->transform($data);
        $this->cache[$deviceProfileId] = $profile;

        return $profile;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getTranslations(string $deviceProfileId, string $tag, bool $skipCache = false): LocalizationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $deviceProfileId, $tag);
        if (!$skipCache) {
            if (isset($this->translationsCache[$cacheKey])) {
                return $this->translationsCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_TRANSLATIONS_SPRINTF, rawurlencode($deviceProfileId), rawurlencode($tag));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $localization = $this->localizationTransformer->transform($data);
        $this->translationsCache[$cacheKey] = $localization;

        return $localization;
    }
}
