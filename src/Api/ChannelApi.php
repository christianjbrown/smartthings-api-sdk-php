<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelCreateRequestInterface;
use ChristianBrown\SmartThings\Model\ChannelDriverInterface;
use ChristianBrown\SmartThings\Model\ChannelInterface;
use ChristianBrown\SmartThings\Model\ChannelUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\DriverChannelCreateRequestInterface;
use ChristianBrown\SmartThings\Model\DriverChannelUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\DriverInterface;
use ChristianBrown\SmartThings\Serializer\ChannelCreateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ChannelUpdateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DriverChannelCreateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DriverChannelUpdateRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;

use function array_filter;
use function is_array;
use function rawurlencode;
use function sprintf;

final class ChannelApi implements ChannelApiInterface
{
    /**
     * @var array<string, ChannelInterface>
     */
    private array $cache = [];
    private ChannelCreateRequestSerializerInterface $channelCreateRequestSerializer;
    private ChannelDriversTransformerInterface $channelDriversTransformer;
    private ChannelDriverTransformerInterface $channelDriverTransformer;
    private ChannelsTransformerInterface $channelsTransformer;
    private ChannelTransformerInterface $channelTransformer;
    private ChannelUpdateRequestSerializerInterface $channelUpdateRequestSerializer;

    /**
     * @var array<string, ChannelDriverInterface>
     */
    private array $driverChannelCache = [];
    private DriverChannelCreateRequestSerializerInterface $driverChannelCreateRequestSerializer;
    private DriverChannelUpdateRequestSerializerInterface $driverChannelUpdateRequestSerializer;

    /**
     * @var array<string, array<int, ChannelDriverInterface>>
     */
    private array $driversCache = [];
    private DriverTransformerInterface $driverTransformer;

    /**
     * @var array<string, array<int, ChannelInterface>>
     */
    private array $listCache = [];

    /**
     * @var array<string, DriverInterface>
     */
    private array $metaCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ChannelTransformerInterface $channelTransformer, ChannelsTransformerInterface $channelsTransformer, ChannelDriversTransformerInterface $channelDriversTransformer, DriverTransformerInterface $driverTransformer, TokenInterface $token, ChannelCreateRequestSerializerInterface $channelCreateRequestSerializer, ChannelUpdateRequestSerializerInterface $channelUpdateRequestSerializer, ChannelDriverTransformerInterface $channelDriverTransformer, DriverChannelCreateRequestSerializerInterface $driverChannelCreateRequestSerializer, DriverChannelUpdateRequestSerializerInterface $driverChannelUpdateRequestSerializer)
    {
        $this->requestSender = $requestSender;
        $this->channelTransformer = $channelTransformer;
        $this->channelsTransformer = $channelsTransformer;
        $this->channelDriversTransformer = $channelDriversTransformer;
        $this->driverTransformer = $driverTransformer;
        $this->token = $token;
        $this->channelCreateRequestSerializer = $channelCreateRequestSerializer;
        $this->channelUpdateRequestSerializer = $channelUpdateRequestSerializer;
        $this->channelDriverTransformer = $channelDriverTransformer;
        $this->driverChannelCreateRequestSerializer = $driverChannelCreateRequestSerializer;
        $this->driverChannelUpdateRequestSerializer = $driverChannelUpdateRequestSerializer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createChannel(ChannelCreateRequestInterface $request): ChannelInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->channelCreateRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->channelTransformer->transform($data);
        $this->listCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createDriverChannel(string $channelId, DriverChannelCreateRequestInterface $request): ChannelDriverInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVERS_SPRINTF, rawurlencode($channelId));
        $body = $this->driverChannelCreateRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->channelDriverTransformer->transform($data);
        unset($this->driversCache[$channelId]);

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteChannel(string $channelId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($channelId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$channelId], $this->driversCache[$channelId]);
        $this->listCache = [];
        $this->metaCache = [];
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteDriverChannel(string $channelId, string $driverId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVER_SPRINTF, rawurlencode($channelId), rawurlencode($driverId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->driversCache[$channelId], $this->driverChannelCache[sprintf(self::CACHE_KEY_SPRINTF, $channelId, $driverId)]);
        $this->metaCache = [];
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDriverChannel(string $channelId, string $driverId, bool $skipCache = false): ChannelDriverInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $channelId, $driverId);
        if (!$skipCache) {
            if (isset($this->driverChannelCache[$cacheKey])) {
                return $this->driverChannelCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVER_SPRINTF, rawurlencode($channelId), rawurlencode($driverId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->channelDriverTransformer->transform($data);
        $this->driverChannelCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDriverMeta(string $channelId, string $driverId, bool $skipCache = false): DriverInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $channelId, $driverId);
        if (!$skipCache) {
            if (isset($this->metaCache[$cacheKey])) {
                return $this->metaCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVER_META_SPRINTF, rawurlencode($channelId), rawurlencode($driverId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $driver = $this->driverTransformer->transform($data);
        $this->metaCache[$cacheKey] = $driver;

        return $driver;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, ChannelDriverInterface>
     */
    public function getDrivers(string $channelId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->driversCache[$channelId])) {
                return $this->driversCache[$channelId];
            }
        }

        $url = sprintf(self::API_URL_DRIVERS_SPRINTF, rawurlencode($channelId));
        $items = $this->fetchList([], $url);
        $channelDrivers = $this->channelDriversTransformer->transform($items);
        $this->driversCache[$channelId] = $channelDrivers;

        return $channelDrivers;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, ChannelInterface>
     */
    public function getMultiple(?string $type = null, ?string $subscriberId = null, ?bool $includeReadOnly = null, bool $skipCache = false): array
    {
        $includeReadOnlyValue = self::includeReadOnlyValue($includeReadOnly);
        $cacheKey = sprintf(self::LIST_CACHE_KEY_SPRINTF, (string) $type, (string) $subscriberId, (string) $includeReadOnlyValue);
        if (!$skipCache) {
            if (isset($this->listCache[$cacheKey])) {
                return $this->listCache[$cacheKey];
            }
        }

        $query = self::buildQuery($type, $subscriberId, $includeReadOnlyValue);
        $items = $this->fetchList($query, self::API_URL);
        $channels = $this->channelsTransformer->transform($items);
        $this->listCache[$cacheKey] = $channels;

        return $channels;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $channelId, bool $skipCache = false): ChannelInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$channelId])) {
                return $this->cache[$channelId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($channelId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $channel = $this->channelTransformer->transform($data);
        $this->cache[$channelId] = $channel;

        return $channel;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateChannel(string $channelId, ChannelUpdateRequestInterface $request): ChannelInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($channelId));
        $body = $this->channelUpdateRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->channelTransformer->transform($data);
        $this->cache[$channelId] = $result;
        $this->listCache = [];

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateDriverChannelVersion(string $channelId, string $driverId, DriverChannelUpdateRequestInterface $request): ChannelDriverInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVER_SPRINTF, rawurlencode($channelId), rawurlencode($driverId));
        $body = $this->driverChannelUpdateRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->channelDriverTransformer->transform($data);
        unset($this->driversCache[$channelId]);
        $this->driverChannelCache[sprintf(self::CACHE_KEY_SPRINTF, $channelId, $driverId)] = $result;

        return $result;
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(?string $type, ?string $subscriberId, ?string $includeReadOnlyValue): array
    {
        // array_filter over a candidate map keeps this a single, branch-free
        // control-flow path regardless of how many optional filters are set,
        // avoiding both the combinatorial path explosion of separate sequential
        // ifs and the unreachable "loop not entered" path of a fixed-size loop.
        return array_filter(
            [
                self::KEY_TYPE => $type,
                self::KEY_SUBSCRIBER_ID => $subscriberId,
                self::KEY_INCLUDE_READ_ONLY => $includeReadOnlyValue,
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }

    /**
     * @param array<string, string> $query
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function fetchList(array $query, string $url): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, $query, $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }

        return $data[self::KEY_ITEMS];
    }

    private static function includeReadOnlyValue(?bool $includeReadOnly): ?string
    {
        if (null === $includeReadOnly) {
            return null;
        }

        return $includeReadOnly ? 'true' : 'false';
    }
}
