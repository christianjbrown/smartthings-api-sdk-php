<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DriverInterface;

interface DriverApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/drivers';
    public const string API_URL_DEFAULT = 'https://api.smartthings.com/v1/drivers/default';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/drivers/%s';
    public const string API_URL_VERSION_SPRINTF = 'https://api.smartthings.com/v1/drivers/%s/versions/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, DriverInterface>
     */
    public function getDefaults(bool $skipCache = false): array;

    /**
     * @return array<int, DriverInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $driverId, bool $skipCache = false): DriverInterface;

    public function getOneByIdAndVersion(string $driverId, string $version, bool $skipCache = false): DriverInterface;
}
