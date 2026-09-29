<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverInterface;
use ChristianBrown\SmartThings\Transformer\DriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class DriverApi implements DriverApiInterface
{
    /**
     * @var array<string, DriverInterface>
     */
    private array $cache = [];

    /**
     * @var ?array<int, DriverInterface>
     */
    private ?array $defaultsCache = null;
    private DriverPackageUploaderInterface $driverPackageUploader;
    private DriversTransformerInterface $driversTransformer;
    private DriverTransformerInterface $driverTransformer;

    /**
     * @var ?array<int, DriverInterface>
     */
    private ?array $listCache = null;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, DriverInterface>
     */
    private array $versionCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, DriverTransformerInterface $driverTransformer, DriversTransformerInterface $driversTransformer, TokenInterface $token, DriverPackageUploaderInterface $driverPackageUploader)
    {
        $this->requestSender = $requestSender;
        $this->driverTransformer = $driverTransformer;
        $this->driversTransformer = $driversTransformer;
        $this->token = $token;
        $this->driverPackageUploader = $driverPackageUploader;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteDriver(string $driverId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($driverId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$driverId]);
        $this->versionCache = [];
        $this->listCache = null;
        $this->defaultsCache = null;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DriverInterface>
     */
    public function getDefaults(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->defaultsCache) {
                return $this->defaultsCache;
            }
        }

        $drivers = $this->fetchList(self::API_URL_DEFAULT);
        $this->defaultsCache = $drivers;

        return $drivers;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DriverInterface>
     */
    public function getMultiple(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->listCache) {
                return $this->listCache;
            }
        }

        $drivers = $this->fetchList(self::API_URL);
        $this->listCache = $drivers;

        return $drivers;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $driverId, bool $skipCache = false): DriverInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$driverId])) {
                return $this->cache[$driverId];
            }
        }

        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($driverId));
        $driver = $this->fetch($url);
        $this->cache[$driverId] = $driver;

        return $driver;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByIdAndVersion(string $driverId, string $version, bool $skipCache = false): DriverInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $driverId, $version);
        if (!$skipCache) {
            if (isset($this->versionCache[$cacheKey])) {
                return $this->versionCache[$cacheKey];
            }
        }

        $url = sprintf(self::API_URL_VERSION_SPRINTF, rawurlencode($driverId), rawurlencode($version));
        $driver = $this->fetch($url);
        $this->versionCache[$cacheKey] = $driver;

        return $driver;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function uploadDriverPackage(string $packageContents): DriverInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->driverPackageUploader->upload(self::API_URL_PACKAGE, $headers, $packageContents);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $driver = $this->driverTransformer->transform($data);
        $this->cache[$driver->getDriverId()] = $driver;
        $this->listCache = null;

        return $driver;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    private function fetch(string $url): DriverInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->driverTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DriverInterface>
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

        return $this->driversTransformer->transform($data[self::KEY_ITEMS]);
    }
}
