<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class InstalledAppApi implements InstalledAppApiInterface
{
    /**
     * @var array<string, InstalledAppInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, InstalledAppConfigInterface>
     */
    private array $configCache = [];

    /**
     * @var array<string, array<int, InstalledAppConfigInterface>>
     */
    private array $configsCache = [];
    private InstalledAppConfigsTransformerInterface $installedAppConfigsTransformer;
    private InstalledAppConfigTransformerInterface $installedAppConfigTransformer;
    private InstalledAppsTransformerInterface $installedAppsTransformer;
    private InstalledAppTransformerInterface $installedAppTransformer;

    /**
     * @var array<string, array<int, InstalledAppInterface>>
     */
    private array $listCache = [];
    private ?InstalledAppInterface $meCache = null;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, InstalledAppTransformerInterface $installedAppTransformer, InstalledAppsTransformerInterface $installedAppsTransformer, InstalledAppConfigTransformerInterface $installedAppConfigTransformer, InstalledAppConfigsTransformerInterface $installedAppConfigsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->installedAppTransformer = $installedAppTransformer;
        $this->installedAppsTransformer = $installedAppsTransformer;
        $this->installedAppConfigTransformer = $installedAppConfigTransformer;
        $this->installedAppConfigsTransformer = $installedAppConfigsTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getConfig(string $installedAppId, string $configurationId, bool $skipCache = false): InstalledAppConfigInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $installedAppId, $configurationId);
        if (!$skipCache) {
            if (isset($this->configCache[$cacheKey])) {
                return $this->configCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CONFIG_SPRINTF, rawurlencode($installedAppId), rawurlencode($configurationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $config = $this->installedAppConfigTransformer->transform($data);
        $this->configCache[$cacheKey] = $config;

        return $config;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, InstalledAppConfigInterface>
     */
    public function getConfigs(string $installedAppId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->configsCache[$installedAppId])) {
                return $this->configsCache[$installedAppId];
            }
        }

        $url = sprintf(self::API_URL_CONFIGS_SPRINTF, rawurlencode($installedAppId));
        $items = $this->fetchList([], $url);
        $configs = $this->installedAppConfigsTransformer->transform($items);
        $this->configsCache[$installedAppId] = $configs;

        return $configs;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getMe(bool $skipCache = false): InstalledAppInterface
    {
        if (!$skipCache) {
            if (null !== $this->meCache) {
                return $this->meCache;
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(self::API_URL_ME, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $installedApp = $this->installedAppTransformer->transform($data);
        $this->meCache = $installedApp;

        return $installedApp;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, InstalledAppInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array
    {
        // Cache per location; casting keeps null and a real id as distinct
        // string keys without adding a null-coalescing branch to this method.
        $cacheKey = (string) $locationId;
        if (!$skipCache) {
            if (isset($this->listCache[$cacheKey])) {
                return $this->listCache[$cacheKey];
            }
        }

        $items = $this->fetchList(self::buildQuery($locationId), self::API_URL);
        $installedApps = $this->installedAppsTransformer->transform($items);
        $this->listCache[$cacheKey] = $installedApps;

        return $installedApps;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $installedAppId, bool $skipCache = false): InstalledAppInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$installedAppId])) {
                return $this->cache[$installedAppId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($installedAppId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $installedApp = $this->installedAppTransformer->transform($data);
        $this->cache[$installedAppId] = $installedApp;

        return $installedApp;
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(?string $locationId): array
    {
        // Isolated so the optional filter is its own path, not multiplied
        // against the cache and response-shape guards in getMultiple().
        if (null === $locationId) {
            return [];
        }

        return [self::KEY_LOCATION_ID => $locationId];
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
}
