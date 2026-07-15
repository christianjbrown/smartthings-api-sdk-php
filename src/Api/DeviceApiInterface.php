<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceInterface;

interface DeviceApiInterface extends ApiInterface
{
    public const API_URL = 'https://api.smartthings.com/v1/devices/';
    public const KEY_ITEMS = 'items';
    public const KEY_LOCATION_ID = 'locationId';
    public const UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, DeviceInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array;
}
