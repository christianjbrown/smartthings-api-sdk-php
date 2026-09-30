<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequestInterface;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializerInterface;
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
     * @var array<string, array<string, DeviceProfileInterface>>
     */
    private array $cache = [];
    private CreateDeviceProfileRequestSerializerInterface $createDeviceProfileRequestSerializer;
    private DeviceProfilesTransformerInterface $deviceProfilesTransformer;
    private DeviceProfileTransformerInterface $deviceProfileTransformer;

    /**
     * @var array<string, array<int, DeviceProfileInterface>>
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
    private UpdateDeviceProfileRequestSerializerInterface $updateDeviceProfileRequestSerializer;
    private RequestUrlBuilderInterface $urlBuilder;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceProfileTransformerInterface $deviceProfileTransformer, DeviceProfilesTransformerInterface $deviceProfilesTransformer, LocaleReferencesTransformerInterface $localeReferencesTransformer, LocalizationTransformerInterface $localizationTransformer, TokenInterface $token, CreateDeviceProfileRequestSerializerInterface $createDeviceProfileRequestSerializer, UpdateDeviceProfileRequestSerializerInterface $updateDeviceProfileRequestSerializer, RequestUrlBuilderInterface $urlBuilder)
    {
        $this->requestSender = $requestSender;
        $this->deviceProfileTransformer = $deviceProfileTransformer;
        $this->deviceProfilesTransformer = $deviceProfilesTransformer;
        $this->localeReferencesTransformer = $localeReferencesTransformer;
        $this->localizationTransformer = $localizationTransformer;
        $this->token = $token;
        $this->createDeviceProfileRequestSerializer = $createDeviceProfileRequestSerializer;
        $this->updateDeviceProfileRequestSerializer = $updateDeviceProfileRequestSerializer;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createDeviceProfile(CreateDeviceProfileRequestInterface $request, ?string $organizationId = null): DeviceProfileInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $body = $this->createDeviceProfileRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $profile = $this->deviceProfileTransformer->transform($data);
        $this->listCache = [];

        return $profile;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteDeviceProfile(string $deviceProfileId, ?string $organizationId = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceProfileId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$deviceProfileId]);
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
     * @param bool                    $skipCache  Fetch again instead of using the cached list
     * @param null|array<int, string> $profileIds
     *
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceProfileInterface>
     */
    public function getMultiple(bool $skipCache = false, ?array $profileIds = null, ?string $organizationId = null): array
    {
        $url = $this->urlBuilder->build(self::API_URL, [self::KEY_PROFILE_ID => $profileIds]);
        $cacheKey = sprintf(self::CACHE_VARIANT_SPRINTF, $url, (string) $organizationId);
        if (!$skipCache) {
            if (isset($this->listCache[$cacheKey])) {
                return $this->listCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $profiles = $this->deviceProfilesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$cacheKey] = $profiles;

        return $profiles;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $deviceProfileId, bool $skipCache = false, ?string $organizationId = null, ?string $acceptLanguage = null): DeviceProfileInterface
    {
        $variant = sprintf(self::CACHE_VARIANT_SPRINTF, (string) $organizationId, (string) $acceptLanguage);
        if (!$skipCache) {
            if (isset($this->cache[$deviceProfileId][$variant])) {
                return $this->cache[$deviceProfileId][$variant];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value) + array_filter([self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceProfileId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $profile = $this->deviceProfileTransformer->transform($data);
        $this->cache[$deviceProfileId][$variant] = $profile;

        return $profile;
    }

    /**
     * @phpstan-impure
     *
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

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateDeviceProfile(string $deviceProfileId, UpdateDeviceProfileRequestInterface $request, ?string $organizationId = null): DeviceProfileInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceProfileId));
        $body = $this->updateDeviceProfileRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $profile = $this->deviceProfileTransformer->transform($data);
        $this->cache[$deviceProfileId] = [self::CACHE_VARIANT_PLAIN => $profile];
        $this->listCache = [];

        return $profile;
    }
}
