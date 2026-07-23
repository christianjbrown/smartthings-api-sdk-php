<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

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

    public function __construct(JsonApiRequestSenderInterface $requestSender, AppTransformerInterface $appTransformer, AppsTransformerInterface $appsTransformer, AppOauthTransformerInterface $appOauthTransformer, AppSettingsTransformerInterface $appSettingsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->appTransformer = $appTransformer;
        $this->appsTransformer = $appsTransformer;
        $this->appOauthTransformer = $appOauthTransformer;
        $this->appSettingsTransformer = $appSettingsTransformer;
        $this->token = $token;
    }

    /**
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
}
