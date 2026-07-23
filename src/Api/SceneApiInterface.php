<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\SceneInterface;

interface SceneApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/scenes';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/scenes/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, SceneInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array;

    public function getOneById(string $sceneId, bool $skipCache = false): SceneInterface;
}
