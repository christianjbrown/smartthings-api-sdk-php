<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;
use ChristianBrown\SmartThings\Model\CreateAppRequestInterface;
use ChristianBrown\SmartThings\Model\CreateAppResponseInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthRequestInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthResponseInterface;
use ChristianBrown\SmartThings\Model\UpdateAppOauthRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateAppRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateAppSettingsRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateSignatureTypeRequestInterface;
use ChristianBrown\SmartThings\Serializer\CreateAppRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\GenerateAppOauthRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppOauthRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppSettingsRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateSignatureTypeRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CreateAppResponseTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GenerateAppOauthResponseTransformerInterface;

use function array_filter;
use function is_array;
use function rawurlencode;
use function sprintf;
use function var_export;

final class AppApi implements AppApiInterface
{
    private AppOauthTransformerInterface $appOauthTransformer;
    private AppSettingsTransformerInterface $appSettingsTransformer;
    private AppsTransformerInterface $appsTransformer;
    private AppTransformerInterface $appTransformer;

    /**
     * @var array<string, AppInterface>
     */
    private array $cache = [];
    private CreateAppRequestSerializerInterface $createAppRequestSerializer;
    private CreateAppResponseTransformerInterface $createAppResponseTransformer;
    private GenerateAppOauthRequestSerializerInterface $generateAppOauthRequestSerializer;
    private GenerateAppOauthResponseTransformerInterface $generateAppOauthResponseTransformer;

    /**
     * @var ?array<int, AppInterface>
     */
    private ?array $listCache = null;

    /**
     * @var array<string, AppOauthInterface>
     */
    private array $oauthCache = [];
    private JsonApiRequestSenderInterface $requestSender;

    /**
     * @var array<string, AppSettingsInterface>
     */
    private array $settingsCache = [];
    private TokenInterface $token;
    private UpdateAppOauthRequestSerializerInterface $updateAppOauthRequestSerializer;
    private UpdateAppRequestSerializerInterface $updateAppRequestSerializer;
    private UpdateAppSettingsRequestSerializerInterface $updateAppSettingsRequestSerializer;
    private UpdateSignatureTypeRequestSerializerInterface $updateSignatureTypeRequestSerializer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, AppTransformerInterface $appTransformer, AppsTransformerInterface $appsTransformer, AppOauthTransformerInterface $appOauthTransformer, AppSettingsTransformerInterface $appSettingsTransformer, TokenInterface $token, CreateAppRequestSerializerInterface $createAppRequestSerializer, CreateAppResponseTransformerInterface $createAppResponseTransformer, UpdateAppRequestSerializerInterface $updateAppRequestSerializer, UpdateAppSettingsRequestSerializerInterface $updateAppSettingsRequestSerializer, UpdateAppOauthRequestSerializerInterface $updateAppOauthRequestSerializer, GenerateAppOauthRequestSerializerInterface $generateAppOauthRequestSerializer, GenerateAppOauthResponseTransformerInterface $generateAppOauthResponseTransformer, UpdateSignatureTypeRequestSerializerInterface $updateSignatureTypeRequestSerializer)
    {
        $this->requestSender = $requestSender;
        $this->appTransformer = $appTransformer;
        $this->appsTransformer = $appsTransformer;
        $this->appOauthTransformer = $appOauthTransformer;
        $this->appSettingsTransformer = $appSettingsTransformer;
        $this->token = $token;
        $this->createAppRequestSerializer = $createAppRequestSerializer;
        $this->createAppResponseTransformer = $createAppResponseTransformer;
        $this->updateAppRequestSerializer = $updateAppRequestSerializer;
        $this->updateAppSettingsRequestSerializer = $updateAppSettingsRequestSerializer;
        $this->updateAppOauthRequestSerializer = $updateAppOauthRequestSerializer;
        $this->generateAppOauthRequestSerializer = $generateAppOauthRequestSerializer;
        $this->generateAppOauthResponseTransformer = $generateAppOauthResponseTransformer;
        $this->updateSignatureTypeRequestSerializer = $updateSignatureTypeRequestSerializer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createApp(CreateAppRequestInterface $request, ?string $signatureType = null, ?bool $requireConfirmation = null, ?string $accountId = null): CreateAppResponseInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $query = array_filter([self::KEY_SIGNATURE_TYPE => $signatureType, self::KEY_REQUIRE_CONFIRMATION => self::formatBool($requireConfirmation), self::KEY_ACCOUNT_ID => $accountId], static fn (?string $value): bool => null !== $value);
        $body = $this->createAppRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, $query, $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->createAppResponseTransformer->transform($data);
        $this->listCache = null;

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteApp(string $appNameOrId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($appNameOrId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$appNameOrId], $this->oauthCache[$appNameOrId], $this->settingsCache[$appNameOrId]);
        $this->listCache = null;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function generateAppOauth(string $appNameOrId, GenerateAppOauthRequestInterface $request): GenerateAppOauthResponseInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_OAUTH_GENERATE_SPRINTF, rawurlencode($appNameOrId));
        $body = $this->generateAppOauthRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->generateAppOauthResponseTransformer->transform($data);
        unset($this->oauthCache[$appNameOrId]);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, AppInterface>
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
        $apps = $this->appsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache = $apps;

        return $apps;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOauth(string $appNameOrId, bool $skipCache = false): AppOauthInterface
    {
        if (!$skipCache) {
            if (isset($this->oauthCache[$appNameOrId])) {
                return $this->oauthCache[$appNameOrId];
            }
        }

        $url = sprintf(self::API_URL_OAUTH_SPRINTF, rawurlencode($appNameOrId));
        $data = $this->fetch($url);
        $oauth = $this->appOauthTransformer->transform($data);
        $this->oauthCache[$appNameOrId] = $oauth;

        return $oauth;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $appNameOrId, bool $skipCache = false): AppInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$appNameOrId])) {
                return $this->cache[$appNameOrId];
            }
        }

        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($appNameOrId));
        $data = $this->fetch($url);
        $app = $this->appTransformer->transform($data);
        $this->cache[$appNameOrId] = $app;

        return $app;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getSettings(string $appNameOrId, bool $skipCache = false): AppSettingsInterface
    {
        if (!$skipCache) {
            if (isset($this->settingsCache[$appNameOrId])) {
                return $this->settingsCache[$appNameOrId];
            }
        }

        $url = sprintf(self::API_URL_SETTINGS_SPRINTF, rawurlencode($appNameOrId));
        $data = $this->fetch($url);
        $settings = $this->appSettingsTransformer->transform($data);
        $this->settingsCache[$appNameOrId] = $settings;

        return $settings;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function register(string $appNameOrId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_REGISTER_SPRINTF, rawurlencode($appNameOrId));
        $this->requestSender->put($url, [], $headers);
        unset($this->cache[$appNameOrId]);
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateApp(string $appNameOrId, UpdateAppRequestInterface $request, ?string $signatureType = null, ?bool $requireConfirmation = null): AppInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($appNameOrId));
        $query = array_filter([self::KEY_SIGNATURE_TYPE => $signatureType, self::KEY_REQUIRE_CONFIRMATION => self::formatBool($requireConfirmation)], static fn (?string $value): bool => null !== $value);
        $body = $this->updateAppRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, $query, $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->appTransformer->transform($data);
        $this->cache[$appNameOrId] = $result;
        $this->listCache = null;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateAppOauth(string $appNameOrId, UpdateAppOauthRequestInterface $request): AppOauthInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_OAUTH_SPRINTF, rawurlencode($appNameOrId));
        $body = $this->updateAppOauthRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->appOauthTransformer->transform($data);
        $this->oauthCache[$appNameOrId] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateAppSettings(string $appNameOrId, UpdateAppSettingsRequestInterface $request): AppSettingsInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SETTINGS_SPRINTF, rawurlencode($appNameOrId));
        $body = $this->updateAppSettingsRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->appSettingsTransformer->transform($data);
        $this->settingsCache[$appNameOrId] = $result;

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function updateSignatureType(string $appNameOrId, UpdateSignatureTypeRequestInterface $request): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SIGNATURE_TYPE_SPRINTF, rawurlencode($appNameOrId));
        $body = $this->updateSignatureTypeRequestSerializer->serialize($request);
        $this->requestSender->put($url, [], $headers, $body);
        unset($this->cache[$appNameOrId]);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function fetch(string $url): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $data;
    }

    private static function formatBool(?bool $value): ?string
    {
        return null === $value ? null : var_export($value, true);
    }
}
