<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformerInterface;

use function rawurlencode;
use function sprintf;

final class ServiceApi implements ServiceApiInterface
{
    /**
     * @var array<string, ServiceCapabilityDataInterface>
     */
    private array $capabilityCache = [];

    /**
     * @var array<string, ServiceLocationInfoInterface>
     */
    private array $infoCache = [];

    /**
     * @var array<string, array<int, string>>
     */
    private array $namesCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private ServiceCapabilityDataTransformerInterface $serviceCapabilityDataTransformer;
    private ServiceCapabilityNamesTransformerInterface $serviceCapabilityNamesTransformer;
    private ServiceLocationInfoTransformerInterface $serviceLocationInfoTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ServiceLocationInfoTransformerInterface $serviceLocationInfoTransformer, ServiceCapabilityNamesTransformerInterface $serviceCapabilityNamesTransformer, ServiceCapabilityDataTransformerInterface $serviceCapabilityDataTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->serviceLocationInfoTransformer = $serviceLocationInfoTransformer;
        $this->serviceCapabilityNamesTransformer = $serviceCapabilityNamesTransformer;
        $this->serviceCapabilityDataTransformer = $serviceCapabilityDataTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, string>
     */
    public function getAvailableCapabilities(string $locationId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->namesCache[$locationId])) {
                return $this->namesCache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CAPABILITIES_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $names = $this->serviceCapabilityNamesTransformer->transform($data);
        $this->namesCache[$locationId] = $names;

        return $names;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getCapability(string $locationId, string $name, bool $skipCache = false): ServiceCapabilityDataInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $locationId, $name);
        if (!$skipCache) {
            if (isset($this->capabilityCache[$cacheKey])) {
                return $this->capabilityCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CAPABILITIES_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [self::KEY_NAME => $name], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $capabilityData = $this->serviceCapabilityDataTransformer->transform($data);
        $this->capabilityCache[$cacheKey] = $capabilityData;

        return $capabilityData;
    }

    /**
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
}
