<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubDeviceUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\HubDriverInstallRequestInterface;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;
use ChristianBrown\SmartThings\Model\HubInterface;
use ChristianBrown\SmartThings\Serializer\HubDeviceUpdateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\HubDriverInstallRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubTransformerInterface;

use function array_filter;
use function rawurlencode;
use function sprintf;
use function var_export;

final class HubApi implements HubApiInterface
{
    /**
     * @var array<string, HubInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, array<int, HubEnrolledChannelInterface>>
     */
    private array $channelsCache = [];

    /**
     * @var array<string, array<string, bool|float|int|string>>
     */
    private array $characteristicsCache = [];

    /**
     * @var array<string, HubInstalledDriverInterface>
     */
    private array $driverCache = [];

    /**
     * @var array<string, array<int, HubInstalledDriverInterface>>
     */
    private array $driversCache = [];
    private HubCharacteristicsTransformerInterface $hubCharacteristicsTransformer;
    private HubDeviceUpdateRequestSerializerInterface $hubDeviceUpdateRequestSerializer;
    private HubDriverInstallRequestSerializerInterface $hubDriverInstallRequestSerializer;
    private HubEnrolledChannelsTransformerInterface $hubEnrolledChannelsTransformer;
    private HubInstalledDriversTransformerInterface $hubInstalledDriversTransformer;
    private HubInstalledDriverTransformerInterface $hubInstalledDriverTransformer;
    private HubTransformerInterface $hubTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, HubTransformerInterface $hubTransformer, HubCharacteristicsTransformerInterface $hubCharacteristicsTransformer, HubInstalledDriverTransformerInterface $hubInstalledDriverTransformer, HubInstalledDriversTransformerInterface $hubInstalledDriversTransformer, HubEnrolledChannelsTransformerInterface $hubEnrolledChannelsTransformer, TokenInterface $token, HubDriverInstallRequestSerializerInterface $hubDriverInstallRequestSerializer, HubDeviceUpdateRequestSerializerInterface $hubDeviceUpdateRequestSerializer)
    {
        $this->requestSender = $requestSender;
        $this->hubTransformer = $hubTransformer;
        $this->hubCharacteristicsTransformer = $hubCharacteristicsTransformer;
        $this->hubInstalledDriverTransformer = $hubInstalledDriverTransformer;
        $this->hubInstalledDriversTransformer = $hubInstalledDriversTransformer;
        $this->hubEnrolledChannelsTransformer = $hubEnrolledChannelsTransformer;
        $this->token = $token;
        $this->hubDriverInstallRequestSerializer = $hubDriverInstallRequestSerializer;
        $this->hubDeviceUpdateRequestSerializer = $hubDeviceUpdateRequestSerializer;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteHubByEui(string $hubEui): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_EUI_SPRINTF, rawurlencode($hubEui));
        $this->requestSender->delete($url, [], $headers);
        $this->cache = [];
        $this->channelsCache = [];
        $this->characteristicsCache = [];
        $this->driverCache = [];
        $this->driversCache = [];
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<string, bool|float|int|string>
     */
    public function getCharacteristics(string $hubId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->characteristicsCache[$hubId])) {
                return $this->characteristicsCache[$hubId];
            }
        }

        $url = sprintf(self::API_URL_CHARACTERISTICS_SPRINTF, rawurlencode($hubId));
        $data = $this->requestSender->get($url, [], $this->headers());
        $characteristics = $this->hubCharacteristicsTransformer->transform($data);
        $this->characteristicsCache[$hubId] = $characteristics;

        return $characteristics;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, HubEnrolledChannelInterface>
     */
    public function getEnrolledChannels(string $hubId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->channelsCache[$hubId])) {
                return $this->channelsCache[$hubId];
            }
        }

        // The enrolled-channels endpoint only lists driver channels, so the
        // channelType filter is fixed; the response is a top-level JSON array.
        $url = sprintf(self::API_URL_CHANNELS_SPRINTF, rawurlencode($hubId));
        $data = $this->requestSender->get($url, [self::KEY_CHANNEL_TYPE => self::CHANNEL_TYPE_DRIVERS], $this->headers());
        $channels = $this->hubEnrolledChannelsTransformer->transform($data);
        $this->channelsCache[$hubId] = $channels;

        return $channels;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getInstalledDriver(string $hubId, string $driverId, bool $skipCache = false): HubInstalledDriverInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $hubId, $driverId);
        if (!$skipCache) {
            if (isset($this->driverCache[$cacheKey])) {
                return $this->driverCache[$cacheKey];
            }
        }

        $url = sprintf(self::API_URL_DRIVER_SPRINTF, rawurlencode($hubId), rawurlencode($driverId));
        $data = $this->requestSender->get($url, [], $this->headers());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $driver = $this->hubInstalledDriverTransformer->transform($data);
        $this->driverCache[$cacheKey] = $driver;

        return $driver;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, HubInstalledDriverInterface>
     */
    public function getInstalledDrivers(string $hubId, ?string $deviceId = null, bool $skipCache = false): array
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $hubId, (string) $deviceId);
        if (!$skipCache) {
            if (isset($this->driversCache[$cacheKey])) {
                return $this->driversCache[$cacheKey];
            }
        }

        // The response is a top-level JSON array, so it is handed to the
        // transformer as-is; an empty array is a valid, non-error result.
        $url = sprintf(self::API_URL_DRIVERS_SPRINTF, rawurlencode($hubId));
        $data = $this->requestSender->get($url, self::buildDriversQuery($deviceId), $this->headers());
        $drivers = $this->hubInstalledDriversTransformer->transform($data);
        $this->driversCache[$cacheKey] = $drivers;

        return $drivers;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $hubId, bool $skipCache = false): HubInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$hubId])) {
                return $this->cache[$hubId];
            }
        }

        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($hubId));
        $data = $this->requestSender->get($url, [], $this->headers());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $hub = $this->hubTransformer->transform($data);
        $this->cache[$hubId] = $hub;

        return $hub;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function installDrivers(string $hubDeviceId, string $driverId, HubDriverInstallRequestInterface $request): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVER_SPRINTF, rawurlencode($hubDeviceId), rawurlencode($driverId));
        $body = $this->hubDriverInstallRequestSerializer->serialize($request);
        $this->requestSender->put($url, [], $headers, $body);
        unset($this->driverCache[sprintf(self::CACHE_KEY_SPRINTF, $hubDeviceId, $driverId)]);
        $this->driversCache = [];
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function uninstallDriver(string $hubDeviceId, string $driverId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DRIVER_SPRINTF, rawurlencode($hubDeviceId), rawurlencode($driverId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->driverCache[sprintf(self::CACHE_KEY_SPRINTF, $hubDeviceId, $driverId)]);
        $this->driversCache = [];
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function updateHubDevice(string $hubDeviceId, string $deviceId, HubDeviceUpdateRequestInterface $request, ?bool $forceUpdate = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CHILD_DEVICE_SPRINTF, rawurlencode($hubDeviceId), rawurlencode($deviceId));
        $query = array_filter([self::KEY_FORCE_UPDATE => self::formatBool($forceUpdate)], static fn (?string $value): bool => null !== $value);
        $body = $this->hubDeviceUpdateRequestSerializer->serialize($request);
        $this->requestSender->patch($url, $query, $headers, $body);
        $this->driversCache = [];
    }

    /**
     * @return array<string, string>
     */
    private static function buildDriversQuery(?string $deviceId): array
    {
        // Isolated so the optional filter is its own path, not multiplied
        // against the cache guard in getInstalledDrivers().
        if (null === $deviceId) {
            return [];
        }

        return [self::KEY_DEVICE_ID => $deviceId];
    }

    private static function formatBool(?bool $value): ?string
    {
        return null === $value ? null : var_export($value, true);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
    }
}
