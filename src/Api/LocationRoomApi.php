<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\MissingInputException;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;

use function rawurlencode;
use function sprintf;

final class LocationRoomApi implements LocationRoomApiInterface
{
    private string $apiToken;

    /**
     * @var array<string, LocationRoomInterface>
     */
    private array $cache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private LocationRoomTransformerInterface $roomTransformer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, LocationRoomTransformerInterface $roomTransformer, string $apiToken)
    {
        $this->requestSender = $requestSender;
        $this->roomTransformer = $roomTransformer;
        $this->apiToken = $apiToken;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws MissingInputException
     * @throws UnexpectedResponseException
     */
    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): LocationRoomInterface
    {
        if (null === $device->getLocationId()) {
            throw new MissingInputException(self::MISSING_LOCATION_ID);
        }
        if (null === $device->getRoomId()) {
            throw new MissingInputException(self::MISSING_ROOM_ID);
        }

        return $this->getOne($device->getLocationId(), $device->getRoomId(), $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByLocationAndId(LocationInterface $location, string $roomId, bool $skipCache = false): LocationRoomInterface
    {
        return $this->getOne($location->getLocationId(), $roomId, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    private function getOne(string $locationId, string $roomId, bool $skipCache): LocationRoomInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$roomId])) {
                return $this->cache[$roomId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => sprintf(self::HEADER_VALUE_AUTHORIZATION_BEARER_SPRINTF, $this->apiToken),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($locationId), rawurlencode($roomId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $room = $this->roomTransformer->transform($data);
        $this->cache[$roomId] = $room;

        return $room;
    }
}
