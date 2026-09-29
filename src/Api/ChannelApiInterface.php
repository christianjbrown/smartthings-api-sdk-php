<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\ChannelCreateRequestInterface;
use ChristianBrown\SmartThings\Model\ChannelDriverInterface;
use ChristianBrown\SmartThings\Model\ChannelInterface;
use ChristianBrown\SmartThings\Model\ChannelUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\DriverChannelCreateRequestInterface;
use ChristianBrown\SmartThings\Model\DriverChannelUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\DriverInterface;

interface ChannelApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/distchannels';
    public const string API_URL_DRIVER_META_SPRINTF = 'https://api.smartthings.com/v1/distchannels/%s/drivers/%s/meta';
    public const string API_URL_DRIVER_SPRINTF = 'https://api.smartthings.com/v1/distchannels/%s/drivers/%s';
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

    /**
     * Creates a distribution channel. Invalidates the cached channel lists.
     */
    public function createChannel(ChannelCreateRequestInterface $request): ChannelInterface;

    /**
     * Adds a driver version to a distribution channel. Invalidates the cached driver list of the channel.
     */
    public function createDriverChannel(string $channelId, DriverChannelCreateRequestInterface $request): ChannelDriverInterface;

    /**
     * Deletes a distribution channel. Invalidates every cached copy of it and the cached channel lists.
     */
    public function deleteChannel(string $channelId): void;

    /**
     * Removes a driver from a distribution channel. Invalidates the cached copies of the driver and the cached driver list of the channel.
     */
    public function deleteDriverChannel(string $channelId, string $driverId): void;

    /**
     * Reads one driver of a distribution channel.
     */
    public function getDriverChannel(string $channelId, string $driverId, bool $skipCache = false): ChannelDriverInterface;

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

    /**
     * Updates a distribution channel. Refreshes the cached copy of the channel and invalidates the cached channel lists.
     */
    public function updateChannel(string $channelId, ChannelUpdateRequestInterface $request): ChannelInterface;

    /**
     * Changes the version of a driver in a distribution channel. Refreshes the cached copy and invalidates the cached driver list of the channel.
     */
    public function updateDriverChannelVersion(string $channelId, string $driverId, DriverChannelUpdateRequestInterface $request): ChannelDriverInterface;
}
