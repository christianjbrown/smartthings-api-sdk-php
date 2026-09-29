<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CreateLocationRequestInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\PatchLocationRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateLocationRequestInterface;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\LocationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class LocationApi implements LocationApiInterface
{
    /**
     * @var array<string, LocationInterface>
     */
    private array $cache = [];
    private CreateLocationRequestSerializerInterface $createLocationRequestSerializer;

    /**
     * @var ?array<int, LocationInterface>
     */
    private ?array $listCache = null;
    private LocationsTransformerInterface $locationsTransformer;
    private LocationTransformerInterface $locationTransformer;
    private PatchLocationRequestSerializerInterface $patchLocationRequestSerializer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;
    private UpdateLocationRequestSerializerInterface $updateLocationRequestSerializer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, LocationTransformerInterface $locationTransformer, LocationsTransformerInterface $locationsTransformer, TokenInterface $token, CreateLocationRequestSerializerInterface $createLocationRequestSerializer, UpdateLocationRequestSerializerInterface $updateLocationRequestSerializer, PatchLocationRequestSerializerInterface $patchLocationRequestSerializer)
    {
        $this->requestSender = $requestSender;
        $this->locationTransformer = $locationTransformer;
        $this->locationsTransformer = $locationsTransformer;
        $this->token = $token;
        $this->createLocationRequestSerializer = $createLocationRequestSerializer;
        $this->updateLocationRequestSerializer = $updateLocationRequestSerializer;
        $this->patchLocationRequestSerializer = $patchLocationRequestSerializer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createLocation(CreateLocationRequestInterface $request): LocationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->createLocationRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $location = $this->locationTransformer->transform($data);
        $this->cache[$location->getLocationId()] = $location;
        $this->listCache = null;

        return $location;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteLocation(string $locationId, ?bool $force = null): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($locationId));
        $this->requestSender->delete($url, self::buildForceQuery($force), $headers);
        unset($this->cache[$locationId]);
        $this->listCache = null;
    }

    /**
     * @phpstan-impure
     *
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
     * @phpstan-impure
     *
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

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function patchLocation(string $locationId, PatchLocationRequestInterface $request): LocationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($locationId));
        $body = $this->patchLocationRequestSerializer->serialize($request);
        $data = $this->requestSender->patch($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $location = $this->locationTransformer->transform($data);
        $this->cache[$locationId] = $location;
        $this->listCache = null;

        return $location;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateLocation(string $locationId, UpdateLocationRequestInterface $request): LocationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($locationId));
        $body = $this->updateLocationRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $location = $this->locationTransformer->transform($data);
        $this->cache[$locationId] = $location;
        $this->listCache = null;

        return $location;
    }

    /**
     * @return array<string, string>
     */
    private static function buildForceQuery(?bool $force): array
    {
        // Isolated so the optional filter is its own path, not multiplied against
        // the guards elsewhere in this class.
        if (null === $force) {
            return [];
        }

        return [self::KEY_FORCE => $force ? 'true' : 'false'];
    }
}
