<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DevicePresentationInterface;
use ChristianBrown\SmartThings\Model\PresentationInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\CreateDeviceConfigRequestTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PresentationTransformerInterface;

use function array_filter;
use function implode;
use function rawurlencode;
use function sprintf;
use function var_export;

final class PresentationApi implements PresentationApiInterface
{
    /**
     * @var array<string, PresentationInterface>
     */
    private array $cache = [];
    private CreateDeviceConfigRequestTransformerInterface $createDeviceConfigRequestTransformer;

    /**
     * @var array<string, PresentationInterface>
     */
    private array $deviceCache = [];

    /**
     * @var array<string, PresentationInterface>
     */
    private array $deviceConfigCache = [];
    private DeviceConfigurationRequestSerializerInterface $deviceConfigurationRequestSerializer;
    private DeviceConfigurationTransformerInterface $deviceConfigurationTransformer;

    /**
     * @var array<string, DevicePresentationInterface>
     */
    private array $devicePresentationCache = [];
    private DevicePresentationTransformerInterface $devicePresentationTransformer;

    /**
     * @var array<string, CreateDeviceConfigRequestInterface>
     */
    private array $generatedDeviceConfigurationCache = [];
    private PresentationTransformerInterface $presentationTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, PresentationInterface>
     */
    private array $typeCache = [];

    /**
     * @var array<string, DeviceConfigurationInterface>
     */
    private array $typedDeviceConfigurationCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, PresentationTransformerInterface $presentationTransformer, TokenInterface $token, DeviceConfigurationRequestSerializerInterface $deviceConfigurationRequestSerializer, DeviceConfigurationTransformerInterface $deviceConfigurationTransformer, DevicePresentationTransformerInterface $devicePresentationTransformer, CreateDeviceConfigRequestTransformerInterface $createDeviceConfigRequestTransformer)
    {
        $this->requestSender = $requestSender;
        $this->presentationTransformer = $presentationTransformer;
        $this->token = $token;
        $this->deviceConfigurationRequestSerializer = $deviceConfigurationRequestSerializer;
        $this->deviceConfigurationTransformer = $deviceConfigurationTransformer;
        $this->devicePresentationTransformer = $devicePresentationTransformer;
        $this->createDeviceConfigRequestTransformer = $createDeviceConfigRequestTransformer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createDeviceConfiguration(DeviceConfigurationRequestInterface $request): DeviceConfigurationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->deviceConfigurationRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL_DEVICE_CONFIG, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->deviceConfigurationTransformer->transform($data);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function generateDeviceConfiguration(string $typeIntegrationId, ?string $typeIntegration = null, ?string $typeShardId = null, ?bool $excludeUndisplayableCapabilitiesFromPresentation = null, bool $skipCache = false): CreateDeviceConfigRequestInterface
    {
        $cacheKey = implode('/', [$typeIntegrationId, (string) $typeIntegration, (string) $typeShardId, var_export($excludeUndisplayableCapabilitiesFromPresentation, true)]);
        if (!$skipCache) {
            if (isset($this->generatedDeviceConfigurationCache[$cacheKey])) {
                return $this->generatedDeviceConfigurationCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, rawurlencode($typeIntegrationId));
        $query = array_filter([self::KEY_TYPE_INTEGRATION => $typeIntegration, self::KEY_TYPE_SHARD_ID => $typeShardId, self::KEY_EXCLUDE_UNDISPLAYABLE_CAPABILITIES_FROM_PRESENTATION => self::formatBool($excludeUndisplayableCapabilitiesFromPresentation)], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get($url, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->createDeviceConfigRequestTransformer->transform($data);
        $this->generatedDeviceConfigurationCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getByDevice(DeviceInterface $device, bool $skipCache = false): PresentationInterface
    {
        return $this->getByDeviceId($device->getDeviceId(), $skipCache);
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getByDeviceId(string $deviceId, bool $skipCache = false): PresentationInterface
    {
        if (!$skipCache) {
            if (isset($this->deviceCache[$deviceId])) {
                return $this->deviceCache[$deviceId];
            }
        }

        $presentation = $this->fetch([self::KEY_DEVICE_ID => $deviceId], self::API_URL);
        $this->deviceCache[$deviceId] = $presentation;

        return $presentation;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDeviceConfig(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $presentationId, (string) $manufacturerName);
        if (!$skipCache) {
            if (isset($this->deviceConfigCache[$cacheKey])) {
                return $this->deviceConfigCache[$cacheKey];
            }
        }

        $presentation = $this->fetch(self::buildQuery($presentationId, $manufacturerName), self::API_URL_DEVICE_CONFIG);
        $this->deviceConfigCache[$cacheKey] = $presentation;

        return $presentation;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDeviceConfigByType(string $typeIntegrationId, bool $skipCache = false): PresentationInterface
    {
        if (!$skipCache) {
            if (isset($this->typeCache[$typeIntegrationId])) {
                return $this->typeCache[$typeIntegrationId];
            }
        }

        $url = sprintf(self::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, rawurlencode($typeIntegrationId));
        $presentation = $this->fetch([], $url);
        $this->typeCache[$typeIntegrationId] = $presentation;

        return $presentation;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDeviceConfiguration(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): DeviceConfigurationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $presentationId, (string) $manufacturerName);
        if (!$skipCache) {
            if (isset($this->typedDeviceConfigurationCache[$cacheKey])) {
                return $this->typedDeviceConfigurationCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $query = array_filter([self::KEY_PRESENTATION_ID => $presentationId, self::KEY_MANUFACTURER_NAME => $manufacturerName], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get(self::API_URL_DEVICE_CONFIG, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->deviceConfigurationTransformer->transform($data);
        $this->typedDeviceConfigurationCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDevicePresentation(string $presentationId, ?string $manufacturerName = null, ?string $deviceId = null, ?string $view = null, ?string $ifNoneMatch = null, ?string $acceptLanguage = null, bool $skipCache = false): DevicePresentationInterface
    {
        $cacheKey = implode('/', [$presentationId, (string) $manufacturerName, (string) $deviceId, (string) $view, (string) $ifNoneMatch, (string) $acceptLanguage]);
        if (!$skipCache) {
            if (isset($this->devicePresentationCache[$cacheKey])) {
                return $this->devicePresentationCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_IF_NONE_MATCH => $ifNoneMatch, self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $query = array_filter([self::KEY_PRESENTATION_ID => $presentationId, self::KEY_MANUFACTURER_NAME => $manufacturerName, self::KEY_DEVICE_ID => $deviceId, self::KEY_VIEW => $view], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get(self::API_URL, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->devicePresentationTransformer->transform($data);
        $this->devicePresentationCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOne(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $presentationId, (string) $manufacturerName);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $presentation = $this->fetch(self::buildQuery($presentationId, $manufacturerName), self::API_URL);
        $this->cache[$cacheKey] = $presentation;

        return $presentation;
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(string $presentationId, ?string $manufacturerName): array
    {
        // The manufacturerName filter is optional, so it is only added when set.
        $query = [self::KEY_PRESENTATION_ID => $presentationId];
        if (null !== $manufacturerName) {
            $query[self::KEY_MANUFACTURER_NAME] = $manufacturerName;
        }

        return $query;
    }

    /**
     * @param array<string, string> $query
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    private function fetch(array $query, string $url): PresentationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->presentationTransformer->transform($data);
    }

    private static function formatBool(?bool $value): ?string
    {
        return null === $value ? null : var_export($value, true);
    }
}
