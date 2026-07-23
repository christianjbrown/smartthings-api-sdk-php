<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;
use ChristianBrown\SmartThings\Model\HubInterface;
use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubTransformerInterface;

use function rawurlencode;
use function sprintf;

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
    private HubEnrolledChannelsTransformerInterface $hubEnrolledChannelsTransformer;
    private HubInstalledDriversTransformerInterface $hubInstalledDriversTransformer;
    private HubInstalledDriverTransformerInterface $hubInstalledDriverTransformer;
    private HubTransformerInterface $hubTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, HubTransformerInterface $hubTransformer, HubCharacteristicsTransformerInterface $hubCharacteristicsTransformer, HubInstalledDriverTransformerInterface $hubInstalledDriverTransformer, HubInstalledDriversTransformerInterface $hubInstalledDriversTransformer, HubEnrolledChannelsTransformerInterface $hubEnrolledChannelsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->hubTransformer = $hubTransformer;
        $this->hubCharacteristicsTransformer = $hubCharacteristicsTransformer;
        $this->hubInstalledDriverTransformer = $hubInstalledDriverTransformer;
        $this->hubInstalledDriversTransformer = $hubInstalledDriversTransformer;
        $this->hubEnrolledChannelsTransformer = $hubEnrolledChannelsTransformer;
        $this->token = $token;
    }

    /**
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
