<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;

interface LocationRoomApiInterface extends ApiInterface
{
    public const string API_URL_DEVICES_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/rooms/%s/devices';
    public const string API_URL_LIST_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/rooms';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/rooms/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_NAME = 'name';
    public const string MISSING_LOCATION_ID = 'Device has no location id';
    public const string MISSING_ROOM_ID = 'Device has no room id';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a new Room in the Location. Invalidates the cached room list for this
     * location so a subsequent getMultiple() reflects the new Room.
     */
    public function createRoom(LocationInterface $location, string $name): LocationRoomInterface;

    /**
     * Deletes a Room from the Location. Invalidates any cached copy of this Room and
     * the cached room list for this location.
     */
    public function deleteRoom(LocationInterface $location, string $roomId): void;

    /**
     * @return array<int, DeviceInterface>
     */
    public function getDevicesInRoom(LocationInterface $location, string $roomId, bool $skipCache = false): array;

    /**
     * @return array<int, LocationRoomInterface>
     */
    public function getMultiple(LocationInterface $location, bool $skipCache = false): array;

    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): LocationRoomInterface;

    public function getOneByLocationAndId(LocationInterface $location, string $roomId, bool $skipCache = false): LocationRoomInterface;

    /**
     * Updates a Room's name. Refreshes the cached copy of this Room and invalidates
     * the cached room list for this location.
     */
    public function updateRoom(LocationInterface $location, string $roomId, string $name): LocationRoomInterface;
}
