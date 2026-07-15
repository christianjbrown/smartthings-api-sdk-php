<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;

use function is_array;
use function sprintf;

final class DeviceApi implements DeviceApiInterface
{
    private string $apiToken;

    /**
     * @var array<string, array<int, DeviceInterface>>
     */
    private array $cache = [];
    private DevicesTransformerInterface $devicesTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DevicesTransformerInterface $devicesTransformer, string $apiToken)
    {
        $this->requestSender = $requestSender;
        $this->devicesTransformer = $devicesTransformer;
        $this->apiToken = $apiToken;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array
    {
        // Cache per location; casting keeps null and a real id as distinct
        // string keys without adding a null-coalescing branch to this method.
        $cacheKey = (string) $locationId;
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => sprintf(self::HEADER_VALUE_AUTHORIZATION_BEARER_SPRINTF, $this->apiToken),
        ];
        $data = $this->requestSender->get(self::API_URL, $this->buildQuery($locationId), $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $devices = $this->devicesTransformer->transform($data[self::KEY_ITEMS]);
        $this->cache[$cacheKey] = $devices;

        return $devices;
    }

    /**
     * @return array<string, string>
     */
    private function buildQuery(?string $locationId): array
    {
        // Isolated so the optional filter is its own path, not multiplied
        // against the cache and response-shape guards in getMultiple().
        if (null === $locationId) {
            return [];
        }

        return [self::KEY_LOCATION_ID => $locationId];
    }
}
