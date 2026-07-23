<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;
use ChristianBrown\SmartThings\Model\HubInterface;

interface HubApiInterface extends ApiInterface
{
    public const string API_URL_CHANNELS_SPRINTF = 'https://api.smartthings.com/v1/hubdevices/%s/channels';
    public const string API_URL_CHARACTERISTICS_SPRINTF = 'https://api.smartthings.com/v1/hubdevices/%s/characteristics';
    public const string API_URL_DRIVER_SPRINTF = 'https://api.smartthings.com/v1/hubdevices/%s/drivers/%s';
    public const string API_URL_DRIVERS_SPRINTF = 'https://api.smartthings.com/v1/hubdevices/%s/drivers';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/hubdevices/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string CHANNEL_TYPE_DRIVERS = 'DRIVERS';
    public const string KEY_CHANNEL_TYPE = 'channelType';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * @return array<string, bool|float|int|string>
     */
    public function getCharacteristics(string $hubId, bool $skipCache = false): array;

    /**
     * @return array<int, HubEnrolledChannelInterface>
     */
    public function getEnrolledChannels(string $hubId, bool $skipCache = false): array;

    public function getInstalledDriver(string $hubId, string $driverId, bool $skipCache = false): HubInstalledDriverInterface;

    /**
     * @return array<int, HubInstalledDriverInterface>
     */
    public function getInstalledDrivers(string $hubId, ?string $deviceId = null, bool $skipCache = false): array;

    public function getOneById(string $hubId, bool $skipCache = false): HubInterface;
}
