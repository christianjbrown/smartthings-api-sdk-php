<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceHealthInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;

interface DeviceHealthApiInterface extends ApiInterface
{
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/health';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): DeviceHealthInterface;

    public function getOneById(string $deviceId, bool $skipCache = false): DeviceHealthInterface;
}
