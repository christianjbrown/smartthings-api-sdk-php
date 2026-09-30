<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\ModeInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class LocationModeApi implements LocationModeApiInterface
{
    /**
     * @var array<string, array<string, ModeInterface>>
     */
    private array $cache = [];

    /**
     * @var array<string, array<string, ModeInterface>>
     */
    private array $currentCache = [];

    /**
     * @var array<string, array<string, array<int, ModeInterface>>>
     */
    private array $listCache = [];
    private ModesTransformerInterface $modesTransformer;
    private ModeTransformerInterface $modeTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;
    private RequestUrlBuilderInterface $urlBuilder;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ModeTransformerInterface $modeTransformer, ModesTransformerInterface $modesTransformer, TokenInterface $token, RequestUrlBuilderInterface $urlBuilder)
    {
        $this->requestSender = $requestSender;
        $this->modeTransformer = $modeTransformer;
        $this->modesTransformer = $modesTransformer;
        $this->token = $token;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function changeCurrent(LocationInterface $location, string $modeId): ModeInterface
    {
        $locationId = $location->getLocationId();

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CURRENT_SPRINTF, rawurlencode($locationId));
        $body = [self::KEY_MODE_ID => $modeId];
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        $this->currentCache[$locationId] = [self::CACHE_LANGUAGE_PLAIN => $mode];

        return $mode;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createMode(LocationInterface $location, string $label, ?string $acceptLanguage = null): ModeInterface
    {
        $locationId = $location->getLocationId();

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($locationId));
        $body = [self::KEY_LABEL => $label];
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        unset($this->listCache[$locationId]);

        return $mode;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteMode(LocationInterface $location, string $modeId, ?string $requestId = null): void
    {
        $locationId = $location->getLocationId();

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = $this->urlBuilder->build(sprintf(self::API_URL_SPRINTF, rawurlencode($locationId), rawurlencode($modeId)), [self::KEY_REQUEST_ID => $requestId]);
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[$modeId], $this->listCache[$locationId]);
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getCurrent(LocationInterface $location, bool $skipCache = false, ?string $acceptLanguage = null): ModeInterface
    {
        $locationId = $location->getLocationId();
        $language = (string) $acceptLanguage;
        if (!$skipCache) {
            if (isset($this->currentCache[$locationId][$language])) {
                return $this->currentCache[$locationId][$language];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_CURRENT_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        $this->currentCache[$locationId][$language] = $mode;

        return $mode;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, ModeInterface>
     */
    public function getMultiple(LocationInterface $location, bool $skipCache = false, ?string $acceptLanguage = null): array
    {
        $locationId = $location->getLocationId();
        $language = (string) $acceptLanguage;
        if (!$skipCache) {
            if (isset($this->listCache[$locationId][$language])) {
                return $this->listCache[$locationId][$language];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $modes = $this->modesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$locationId][$language] = $modes;

        return $modes;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByLocationAndId(LocationInterface $location, string $modeId, bool $skipCache = false, ?string $acceptLanguage = null): ModeInterface
    {
        $language = (string) $acceptLanguage;
        if (!$skipCache) {
            if (isset($this->cache[$modeId][$language])) {
                return $this->cache[$modeId][$language];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($location->getLocationId()), rawurlencode($modeId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        $this->cache[$modeId][$language] = $mode;

        return $mode;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateMode(LocationInterface $location, string $modeId, string $label, ?string $acceptLanguage = null): ModeInterface
    {
        $locationId = $location->getLocationId();

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($locationId), rawurlencode($modeId));
        $body = [self::KEY_LABEL => $label];
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        $this->cache[$modeId] = [self::CACHE_LANGUAGE_PLAIN => $mode];
        unset($this->listCache[$locationId]);

        return $mode;
    }
}
