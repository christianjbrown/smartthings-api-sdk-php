<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Transformer\LocationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class LocationApi implements LocationApiInterface
{
    private TokenInterface $token;

    /**
     * @var array<string, LocationInterface>
     */
    private array $cache = [];

    /**
     * @var ?array<int, LocationInterface>
     */
    private ?array $listCache = null;
    private LocationsTransformerInterface $locationsTransformer;
    private LocationTransformerInterface $locationTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, LocationTransformerInterface $locationTransformer, LocationsTransformerInterface $locationsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->locationTransformer = $locationTransformer;
        $this->locationsTransformer = $locationsTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, LocationInterface>
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
        $locations = $this->locationsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache = $locations;

        return $locations;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $locationId, bool $skipCache = false): LocationInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$locationId])) {
                return $this->cache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $location = $this->locationTransformer->transform($data);
        $this->cache[$locationId] = $location;

        return $location;
    }
}
