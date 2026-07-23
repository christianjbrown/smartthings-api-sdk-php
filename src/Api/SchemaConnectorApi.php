<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaPageInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class SchemaConnectorApi implements SchemaConnectorApiInterface
{
    /**
     * @var array<string, SchemaAppInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, InstalledSchemaAppInterface>
     */
    private array $installedCache = [];

    /**
     * @var array<string, array<int, InstalledSchemaAppInterface>>
     */
    private array $installedListCache = [];
    private InstalledSchemaAppsTransformerInterface $installedSchemaAppsTransformer;
    private InstalledSchemaAppTransformerInterface $installedSchemaAppTransformer;

    /**
     * @var ?array<int, SchemaAppInterface>
     */
    private ?array $listCache = null;

    /**
     * @var array<string, SchemaPageInterface>
     */
    private array $pageCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private SchemaAppsTransformerInterface $schemaAppsTransformer;
    private SchemaAppTransformerInterface $schemaAppTransformer;
    private SchemaPageTransformerInterface $schemaPageTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, SchemaAppTransformerInterface $schemaAppTransformer, SchemaAppsTransformerInterface $schemaAppsTransformer, InstalledSchemaAppTransformerInterface $installedSchemaAppTransformer, InstalledSchemaAppsTransformerInterface $installedSchemaAppsTransformer, SchemaPageTransformerInterface $schemaPageTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->schemaAppTransformer = $schemaAppTransformer;
        $this->schemaAppsTransformer = $schemaAppsTransformer;
        $this->installedSchemaAppTransformer = $installedSchemaAppTransformer;
        $this->installedSchemaAppsTransformer = $installedSchemaAppsTransformer;
        $this->schemaPageTransformer = $schemaPageTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getInstalledById(string $isaId, bool $skipCache = false): InstalledSchemaAppInterface
    {
        if (!$skipCache) {
            if (isset($this->installedCache[$isaId])) {
                return $this->installedCache[$isaId];
            }
        }

        $url = sprintf(self::API_URL_INSTALLED_APP_SPRINTF, rawurlencode($isaId));
        $data = $this->requestSender->get($url, [], $this->headers());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $app = $this->installedSchemaAppTransformer->transform($data);
        $this->installedCache[$isaId] = $app;

        return $app;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, InstalledSchemaAppInterface>
     */
    public function getInstalledMultiple(string $locationId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->installedListCache[$locationId])) {
                return $this->installedListCache[$locationId];
            }
        }

        $url = sprintf(self::API_URL_INSTALLED_APPS_LOCATION_SPRINTF, rawurlencode($locationId));
        $items = $this->fetchWrapped($url, self::KEY_INSTALLED_SMART_APPS);
        $apps = $this->installedSchemaAppsTransformer->transform($items);
        $this->installedListCache[$locationId] = $apps;

        return $apps;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getInstallPage(string $endpointAppId, string $locationId, bool $skipCache = false): SchemaPageInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $endpointAppId, $locationId);
        if (!$skipCache) {
            if (isset($this->pageCache[$cacheKey])) {
                return $this->pageCache[$cacheKey];
            }
        }

        $url = sprintf(self::API_URL_INSTALL_SPRINTF, rawurlencode($endpointAppId));
        $query = [self::KEY_LOCATION_ID => $locationId, self::KEY_TYPE => self::TYPE_OAUTH_LINK];
        $data = $this->requestSender->get($url, $query, $this->headers());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $page = $this->schemaPageTransformer->transform($data);
        $this->pageCache[$cacheKey] = $page;

        return $page;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, SchemaAppInterface>
     */
    public function getMultiple(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->listCache) {
                return $this->listCache;
            }
        }

        $items = $this->fetchWrapped(self::API_URL_APPS, self::KEY_ENDPOINT_APPS);
        $apps = $this->schemaAppsTransformer->transform($items);
        $this->listCache = $apps;

        return $apps;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $endpointAppId, bool $skipCache = false): SchemaAppInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$endpointAppId])) {
                return $this->cache[$endpointAppId];
            }
        }

        $url = sprintf(self::API_URL_APP_SPRINTF, rawurlencode($endpointAppId));
        $data = $this->requestSender->get($url, [], $this->headers());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $app = $this->schemaAppTransformer->transform($data);
        $this->cache[$endpointAppId] = $app;

        return $app;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function fetchWrapped(string $url, string $wrapperKey): array
    {
        // The schema list responses wrap their items in a named key (endpointApps
        // or installedSmartApps) rather than the usual "items"; an empty array is
        // a valid result, so isset/is_array guards are used rather than empty().
        $data = $this->requestSender->get($url, [], $this->headers());

        if (!isset($data[$wrapperKey])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, $wrapperKey));
        }
        if (!is_array($data[$wrapperKey])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, $wrapperKey));
        }

        return $data[$wrapperKey];
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
