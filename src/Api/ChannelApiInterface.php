<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\ChannelDriverInterface;
use ChristianBrown\SmartThings\Model\ChannelInterface;
use ChristianBrown\SmartThings\Model\DriverInterface;

interface ChannelApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/distchannels';
    public const string API_URL_DRIVER_META_SPRINTF = 'https://api.smartthings.com/v1/distchannels/%s/drivers/%s/meta';
    public const string API_URL_DRIVERS_SPRINTF = 'https://api.smartthings.com/v1/distchannels/%s/drivers';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/distchannels/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_INCLUDE_READ_ONLY = 'includeReadOnly';
    public const string KEY_ITEMS = 'items';
    public const string KEY_SUBSCRIBER_ID = 'subscriberId';
    public const string KEY_TYPE = 'type';
    public const string LIST_CACHE_KEY_SPRINTF = '%s/%s/%s';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    public function getDriverMeta(string $channelId, string $driverId, bool $skipCache = false): DriverInterface;

    /**
     * @return array<int, ChannelDriverInterface>
     */
    public function getDrivers(string $channelId, bool $skipCache = false): array;

    /**
     * @return array<int, ChannelInterface>
     */
    public function getMultiple(?string $type = null, ?string $subscriberId = null, ?bool $includeReadOnly = null, bool $skipCache = false): array;

    public function getOneById(string $channelId, bool $skipCache = false): ChannelInterface;
}
