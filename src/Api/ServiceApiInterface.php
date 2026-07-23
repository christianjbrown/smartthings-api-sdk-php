<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;

interface ServiceApiInterface extends ApiInterface
{
    public const string API_URL_CAPABILITIES_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s/capabilities';
    public const string API_URL_INFO_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * @return array<int, string>
     */
    public function getAvailableCapabilities(string $locationId, bool $skipCache = false): array;

    public function getCapability(string $locationId, string $name, bool $skipCache = false): ServiceCapabilityDataInterface;

    public function getLocationInfo(string $locationId, bool $skipCache = false): ServiceLocationInfoInterface;
}
