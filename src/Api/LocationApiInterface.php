<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\LocationInterface;

interface LocationApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/locations';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/locations/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, LocationInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $locationId, bool $skipCache = false): LocationInterface;
}
