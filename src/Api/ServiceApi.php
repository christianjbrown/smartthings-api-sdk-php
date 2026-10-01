<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;
use ChristianBrown\SmartThings\Model\ServiceSubscriptionReceiptInterface;
use ChristianBrown\SmartThings\Model\ServiceSubscriptionRequestInterface;
use ChristianBrown\SmartThings\Serializer\ServiceSubscriptionRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceSubscriptionReceiptTransformerInterface;

use function array_filter;
use function is_string;
use function rawurlencode;
use function sprintf;

final class ServiceApi implements ServiceApiInterface
{
    private JsonReadApiRequestSenderInterface $alertLinkRequestSender;

    /**
     * @var array<string, ServiceCapabilityDataInterface>
     */
    private array $capabilityCache = [];

    /**
     * @var array<string, ServiceLocationInfoInterface>
     */
    private array $infoCache = [];

    /**
     * @var array<string, array<string, array<int, string>>>
     */
    private array $namesCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private ServiceCapabilityDataTransformerInterface $serviceCapabilityDataTransformer;
    private ServiceCapabilityNamesTransformerInterface $serviceCapabilityNamesTransformer;
    private ServiceLocationInfoTransformerInterface $serviceLocationInfoTransformer;
    private ServiceSubscriptionReceiptTransformerInterface $serviceSubscriptionReceiptTransformer;
    private ServiceSubscriptionRequestSerializerInterface $serviceSubscriptionRequestSerializer;
    private TokenInterface $token;
    private RequestUrlBuilderInterface $urlBuilder;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ServiceLocationInfoTransformerInterface $serviceLocationInfoTransformer, ServiceCapabilityNamesTransformerInterface $serviceCapabilityNamesTransformer, ServiceCapabilityDataTransformerInterface $serviceCapabilityDataTransformer, TokenInterface $token, ServiceSubscriptionRequestSerializerInterface $serviceSubscriptionRequestSerializer, ServiceSubscriptionReceiptTransformerInterface $serviceSubscriptionReceiptTransformer, RequestUrlBuilderInterface $urlBuilder, JsonReadApiRequestSenderInterface $alertLinkRequestSender)
    {
        $this->requestSender = $requestSender;
        $this->serviceLocationInfoTransformer = $serviceLocationInfoTransformer;
        $this->serviceCapabilityNamesTransformer = $serviceCapabilityNamesTransformer;
        $this->serviceCapabilityDataTransformer = $serviceCapabilityDataTransformer;
        $this->token = $token;
        $this->serviceSubscriptionRequestSerializer = $serviceSubscriptionRequestSerializer;
        $this->serviceSubscriptionReceiptTransformer = $serviceSubscriptionReceiptTransformer;
        $this->urlBuilder = $urlBuilder;
        $this->alertLinkRequestSender = $alertLinkRequestSender;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createSubscription(string $locationId, ServiceSubscriptionRequestInterface $request): ServiceSubscriptionReceiptInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SUBSCRIPTIONS_SPRINTF, rawurlencode($locationId));
        $body = $this->serviceSubscriptionRequestSerializer->serialize($request);
        $data = $this->requestSender->post($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->serviceSubscriptionReceiptTransformer->transform($data);
        unset($this->infoCache[$locationId]);

        return $result;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteSubscription(string $locationId, string $subscriptionId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SUBSCRIPTION_SPRINTF, rawurlencode($locationId), rawurlencode($subscriptionId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->infoCache[$locationId]);
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteSubscriptionsByInstalledApp(string $locationId, string $isaId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SUBSCRIPTIONS_SPRINTF, rawurlencode($locationId));
        $query = array_filter([self::KEY_ISA_ID => $isaId], static fn (?string $value): bool => null !== $value);
        $this->requestSender->delete($url, $query, $headers);
        unset($this->infoCache[$locationId]);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getAlertLink(string $locationId, ?string $postalCode = null, ?string $subscriptionId = null, ?string $units = null, ?string $acceptLanguage = null): string
    {
        $url = $this->urlBuilder->build(sprintf(self::API_URL_ALERT_LINK_SPRINTF, rawurlencode($locationId)), [self::KEY_POSTAL_CODE => $postalCode, self::KEY_SUBSCRIPTION_ID => $subscriptionId]);
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_UNITS => $units, self::HEADER_KEY_ACCEPT_LANGUAGE => $acceptLanguage], static fn (?string $value): bool => null !== $value);

        $data = $this->alertLinkRequestSender->get($url, [], $headers);

        if (!isset($data[self::KEY_LOCATION])) {
            throw new UnexpectedResponseException(self::UNEXPECTED_LOCATION);
        }
        if (!is_string($data[self::KEY_LOCATION])) {
            throw new UnexpectedResponseException(self::UNEXPECTED_LOCATION);
        }

        return $data[self::KEY_LOCATION];
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, string>
     */
    public function getAvailableCapabilities(string $locationId, bool $skipCache = false, ?string $postalCode = null): array
    {
        $url = $this->urlBuilder->build(sprintf(self::API_URL_CAPABILITIES_SPRINTF, rawurlencode($locationId)), [self::KEY_POSTAL_CODE => $postalCode]);
        if (!$skipCache) {
            if (isset($this->namesCache[$locationId][$url])) {
                return $this->namesCache[$locationId][$url];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $names = $this->serviceCapabilityNamesTransformer->transform($data);
        $this->namesCache[$locationId][$url] = $names;

        return $names;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getCapability(string $locationId, string $name, bool $skipCache = false, ?string $postalCode = null): ServiceCapabilityDataInterface
    {
        $url = $this->urlBuilder->build(sprintf(self::API_URL_CAPABILITIES_SPRINTF, rawurlencode($locationId)), [self::KEY_NAME => $name, self::KEY_POSTAL_CODE => $postalCode]);
        $cacheKey = $url;
        if (!$skipCache) {
            if (isset($this->capabilityCache[$cacheKey])) {
                return $this->capabilityCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $capabilityData = $this->serviceCapabilityDataTransformer->transform($data);
        $this->capabilityCache[$cacheKey] = $capabilityData;

        return $capabilityData;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getLocationInfo(string $locationId, bool $skipCache = false): ServiceLocationInfoInterface
    {
        if (!$skipCache) {
            if (isset($this->infoCache[$locationId])) {
                return $this->infoCache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_INFO_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $info = $this->serviceLocationInfoTransformer->transform($data);
        $this->infoCache[$locationId] = $info;

        return $info;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function updateSubscription(string $locationId, string $subscriptionId, ServiceSubscriptionRequestInterface $request): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SUBSCRIPTION_SPRINTF, rawurlencode($locationId), rawurlencode($subscriptionId));
        $body = $this->serviceSubscriptionRequestSerializer->serialize($request);
        $this->requestSender->put($url, [], $headers, $body);
        unset($this->infoCache[$locationId]);
    }
}
