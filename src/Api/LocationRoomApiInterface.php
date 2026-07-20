<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;

interface LocationRoomApiInterface extends ApiInterface
{
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/rooms/%s';
    public const string MISSING_LOCATION_ID = 'Device has no location id';
    public const string MISSING_ROOM_ID = 'Device has no room id';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): LocationRoomInterface;

    public function getOneByLocationAndId(LocationInterface $location, string $roomId, bool $skipCache = false): LocationRoomInterface;
}
