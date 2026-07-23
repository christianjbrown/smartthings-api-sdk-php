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
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class LocationRoomApi implements LocationRoomApiInterface
{
    /**
     * @var array<string, LocationRoomInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, array<int, DeviceInterface>>
     */
    private array $devicesCache = [];
    private DevicesTransformerInterface $devicesTransformer;

    /**
     * @var array<string, array<int, LocationRoomInterface>>
     */
    private array $listCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private LocationRoomsTransformerInterface $roomsTransformer;
    private LocationRoomTransformerInterface $roomTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, LocationRoomTransformerInterface $roomTransformer, LocationRoomsTransformerInterface $roomsTransformer, DevicesTransformerInterface $devicesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->roomTransformer = $roomTransformer;
        $this->roomsTransformer = $roomsTransformer;
        $this->devicesTransformer = $devicesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceInterface>
     */
    public function getDevicesInRoom(LocationInterface $location, string $roomId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->devicesCache[$roomId])) {
                return $this->devicesCache[$roomId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_DEVICES_SPRINTF, rawurlencode($location->getLocationId()), rawurlencode($roomId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $devices = $this->devicesTransformer->transform($data[self::KEY_ITEMS]);
        $this->devicesCache[$roomId] = $devices;

        return $devices;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, LocationRoomInterface>
     */
    public function getMultiple(LocationInterface $location, bool $skipCache = false): array
    {
        $locationId = $location->getLocationId();
        if (!$skipCache) {
            if (isset($this->listCache[$locationId])) {
                return $this->listCache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $rooms = $this->roomsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$locationId] = $rooms;

        return $rooms;
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
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
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
