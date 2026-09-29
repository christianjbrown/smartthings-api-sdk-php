<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SubscriptionInterface;
use ChristianBrown\SmartThings\Model\SubscriptionRequestInterface;
use ChristianBrown\SmartThings\Serializer\SubscriptionRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformerInterface;

use function array_filter;
use function is_array;
use function rawurlencode;
use function sprintf;

final class SubscriptionApi implements SubscriptionApiInterface
{
    /**
     * @var array<string, SubscriptionInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, array<int, SubscriptionInterface>>
     */
    private array $listCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private SubscriptionRequestSerializerInterface $subscriptionRequestSerializer;
    private SubscriptionsTransformerInterface $subscriptionsTransformer;
    private SubscriptionTransformerInterface $subscriptionTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, SubscriptionTransformerInterface $subscriptionTransformer, SubscriptionsTransformerInterface $subscriptionsTransformer, TokenInterface $token, SubscriptionRequestSerializerInterface $subscriptionRequestSerializer)
    {
        $this->requestSender = $requestSender;
        $this->subscriptionTransformer = $subscriptionTransformer;
        $this->subscriptionsTransformer = $subscriptionsTransformer;
        $this->token = $token;
        $this->subscriptionRequestSerializer = $subscriptionRequestSerializer;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteAllSubscriptions(string $installedAppId, ?string $deviceId = null, ?string $modeId = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($installedAppId));
        $query = array_filter([self::KEY_DEVICE_ID => $deviceId, self::KEY_MODE_ID => $modeId], static fn (?string $value): bool => null !== $value);
        $this->requestSender->delete($url, $query, $headers);
        $this->cache = [];
        unset($this->listCache[$installedAppId]);
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteSubscription(string $installedAppId, string $subscriptionId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($installedAppId), rawurlencode($subscriptionId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->cache[sprintf(self::CACHE_KEY_SPRINTF, $installedAppId, $subscriptionId)], $this->listCache[$installedAppId]);
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, SubscriptionInterface>
     */
    public function getMultiple(string $installedAppId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->listCache[$installedAppId])) {
                return $this->listCache[$installedAppId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($installedAppId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $subscriptions = $this->subscriptionsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$installedAppId] = $subscriptions;

        return $subscriptions;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $installedAppId, string $subscriptionId, bool $skipCache = false): SubscriptionInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $installedAppId, $subscriptionId);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($installedAppId), rawurlencode($subscriptionId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $subscription = $this->subscriptionTransformer->transform($data);
        $this->cache[$cacheKey] = $subscription;

        return $subscription;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function saveSubscription(string $installedAppId, SubscriptionRequestInterface $request): SubscriptionInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($installedAppId));
        $body = $this->subscriptionRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->subscriptionTransformer->transform($data);
        unset($this->listCache[$installedAppId]);

        return $result;
    }
}
