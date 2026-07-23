<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;

interface DeviceHistoryApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/history/devices';
    public const string CACHE_KEY_SPRINTF = '%s/%s/%s/%s';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_HREF = 'href';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LINKS = '_links';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NEXT = 'next';
    public const string KEY_OLDEST_FIRST = 'oldestFirst';
    public const string OLDEST_FIRST_TRUE = 'true';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, DeviceHistoryEventInterface>
     */
    public function getMultiple(?string $deviceId = null, ?string $locationId = null, bool $oldestFirst = false, ?int $maxPages = null, bool $skipCache = false): array;
}
