<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

interface DeviceProfileApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/deviceprofiles';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/deviceprofiles/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, DeviceProfileInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $deviceProfileId, bool $skipCache = false): DeviceProfileInterface;
}
