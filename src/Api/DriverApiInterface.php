<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DriverInterface;

interface DriverApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/drivers';
    public const string API_URL_DEFAULT = 'https://api.smartthings.com/v1/drivers/default';
    public const string API_URL_PACKAGE = 'https://api.smartthings.com/v1/drivers/package';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/drivers/%s';
    public const string API_URL_VERSION_SPRINTF = 'https://api.smartthings.com/v1/drivers/%s/versions/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_DRIVER_IDS = 'driverIds';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Deletes a driver. Invalidates every cached copy of it and the cached driver lists.
     */
    public function deleteDriver(string $driverId): void;

    /**
     * @return array<int, DriverInterface>
     */
    public function getDefaults(bool $skipCache = false): array;

    /**
     * @param bool                    $skipCache Fetch again instead of using the cached list
     * @param null|array<int, string> $driverIds
     *
     * @return array<int, DriverInterface>
     */
    public function getMultiple(bool $skipCache = false, ?array $driverIds = null): array;

    public function getOneById(string $driverId, bool $skipCache = false): DriverInterface;

    public function getOneByIdAndVersion(string $driverId, string $version, bool $skipCache = false): DriverInterface;

    /**
     * Uploads a driver package (a zip archive of the driver and its profile definitions) and returns the
     * created driver. Refreshes the cached copy of the driver and invalidates the cached driver lists.
     */
    public function uploadDriverPackage(string $packageContents): DriverInterface;
}
