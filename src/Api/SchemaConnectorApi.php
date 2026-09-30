<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppCreateRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppReceiptInterface;
use ChristianBrown\SmartThings\Model\SchemaAppUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaOauthCredentialsRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaPageInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppCreateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppUpdateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SchemaOauthCredentialsRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppReceiptTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformerInterface;

use function array_filter;
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
     * @var array<string, array<string, InstalledSchemaAppInterface>>
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
     * @var array<string, array<int, SchemaAppInterface>>
     */
    private array $organizationAppsCache = [];

    /**
     * @var array<string, SchemaPageInterface>
     */
    private array $pageCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private SchemaAppCreateRequestSerializerInterface $schemaAppCreateRequestSerializer;
    private SchemaAppReceiptTransformerInterface $schemaAppReceiptTransformer;
    private SchemaAppsTransformerInterface $schemaAppsTransformer;
    private SchemaAppTransformerInterface $schemaAppTransformer;
    private SchemaAppUpdateRequestSerializerInterface $schemaAppUpdateRequestSerializer;
    private SchemaOauthCredentialsRequestSerializerInterface $schemaOauthCredentialsRequestSerializer;
    private SchemaPageTransformerInterface $schemaPageTransformer;
    private TokenInterface $token;
    private RequestUrlBuilderInterface $urlBuilder;

    /**
     * @var array<string, array<int, SchemaAppInterface>>
     */
    private array $userAppsCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, SchemaAppTransformerInterface $schemaAppTransformer, SchemaAppsTransformerInterface $schemaAppsTransformer, InstalledSchemaAppTransformerInterface $installedSchemaAppTransformer, InstalledSchemaAppsTransformerInterface $installedSchemaAppsTransformer, SchemaPageTransformerInterface $schemaPageTransformer, TokenInterface $token, SchemaAppCreateRequestSerializerInterface $schemaAppCreateRequestSerializer, SchemaAppReceiptTransformerInterface $schemaAppReceiptTransformer, SchemaAppUpdateRequestSerializerInterface $schemaAppUpdateRequestSerializer, SchemaOauthCredentialsRequestSerializerInterface $schemaOauthCredentialsRequestSerializer, RequestUrlBuilderInterface $urlBuilder)
    {
        $this->requestSender = $requestSender;
        $this->schemaAppTransformer = $schemaAppTransformer;
        $this->schemaAppsTransformer = $schemaAppsTransformer;
        $this->installedSchemaAppTransformer = $installedSchemaAppTransformer;
        $this->installedSchemaAppsTransformer = $installedSchemaAppsTransformer;
        $this->schemaPageTransformer = $schemaPageTransformer;
        $this->token = $token;
        $this->schemaAppCreateRequestSerializer = $schemaAppCreateRequestSerializer;
        $this->schemaAppReceiptTransformer = $schemaAppReceiptTransformer;
        $this->schemaAppUpdateRequestSerializer = $schemaAppUpdateRequestSerializer;
        $this->schemaOauthCredentialsRequestSerializer = $schemaOauthCredentialsRequestSerializer;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createApp(SchemaAppCreateRequestInterface $request, ?string $organizationId = null): SchemaAppReceiptInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $body = $this->schemaAppCreateRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL_APPS, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->schemaAppReceiptTransformer->transform($data);
        $this->listCache = null;

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteApp(string $endpointAppId, ?string $organizationId = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_APP_SPRINTF, rawurlencode($endpointAppId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$endpointAppId]);
        $this->listCache = null;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteInstalled(string $isaId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_INSTALLED_APP_SPRINTF, rawurlencode($isaId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->installedCache[$isaId]);
        $this->installedListCache = [];
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function generateStOauthCredentials(SchemaOauthCredentialsRequestInterface $request, ?string $organizationId = null): SchemaAppReceiptInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $body = $this->schemaOauthCredentialsRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL_OAUTH_CREDENTIALS, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->schemaAppReceiptTransformer->transform($data);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, SchemaAppInterface>
     */
    public function getByOrganization(?string $organizationId = null, bool $skipCache = false): array
    {
        $cacheKey = (string) $organizationId;
        if (!$skipCache) {
            if (isset($this->organizationAppsCache[$cacheKey])) {
                return $this->organizationAppsCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION_ID => $organizationId], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get(self::API_URL_ORGANIZATION_APPS, [], $headers);

        if (!isset($data[self::KEY_ENDPOINT_APPS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ENDPOINT_APPS));
        }
        if (!is_array($data[self::KEY_ENDPOINT_APPS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ENDPOINT_APPS));
        }
        $result = $this->schemaAppsTransformer->transform($data[self::KEY_ENDPOINT_APPS]);
        $this->organizationAppsCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, SchemaAppInterface>
     */
    public function getByUserId(string $userId, bool $skipCache = false): array
    {
        $cacheKey = $userId;
        if (!$skipCache) {
            if (isset($this->userAppsCache[$cacheKey])) {
                return $this->userAppsCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_USER_APPS_SPRINTF, rawurlencode($userId));
        $data = $this->requestSender->get($url, [], $headers);

        if (!isset($data[self::KEY_ENDPOINT_APPS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ENDPOINT_APPS));
        }
        if (!is_array($data[self::KEY_ENDPOINT_APPS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ENDPOINT_APPS));
        }
        $result = $this->schemaAppsTransformer->transform($data[self::KEY_ENDPOINT_APPS]);
        $this->userAppsCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getInstalledById(string $isaId, bool $skipCache = false, ?bool $redirectRequested = null, ?bool $jsonRspRequested = null): InstalledSchemaAppInterface
    {
        $url = $this->urlBuilder->build(sprintf(self::API_URL_INSTALLED_APP_SPRINTF, rawurlencode($isaId)), [self::KEY_REDIRECT_REQUESTED => $redirectRequested, self::KEY_JSON_RSP_REQUESTED => $jsonRspRequested]);
        if (!$skipCache) {
            if (isset($this->installedCache[$isaId][$url])) {
                return $this->installedCache[$isaId][$url];
            }
        }

        $data = $this->requestSender->get($url, [], $this->headers());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $app = $this->installedSchemaAppTransformer->transform($data);
        $this->installedCache[$isaId][$url] = $app;

        return $app;
    }

    /**
     * @phpstan-impure
     *
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
     * @phpstan-impure
     *
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
     * @phpstan-impure
     *
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
     * @phpstan-impure
     *
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
     */
    public function updateApp(string $endpointAppId, SchemaAppUpdateRequestInterface $request, ?string $organizationId = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION => $organizationId], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_APP_SPRINTF, rawurlencode($endpointAppId));
        $body = $this->schemaAppUpdateRequestSerializer->serialize($request);
        $this->requestSender->put($url, [], $headers, $body);
        unset($this->cache[$endpointAppId]);
        $this->listCache = null;
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
