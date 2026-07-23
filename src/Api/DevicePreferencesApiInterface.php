<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;

interface DevicePreferencesApiInterface extends ApiInterface
{
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/preferences';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * @return array<int, DevicePreferenceInterface>
     */
    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): array;

    /**
     * @return array<int, DevicePreferenceInterface>
     */
    public function getOneById(string $deviceId, bool $skipCache = false): array;
}
