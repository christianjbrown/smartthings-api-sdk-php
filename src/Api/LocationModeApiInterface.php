<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\ModeInterface;

interface LocationModeApiInterface extends ApiInterface
{
    public const string API_URL_CURRENT_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/modes/current';
    public const string API_URL_LIST_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/modes';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/modes/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    public function getCurrent(LocationInterface $location, bool $skipCache = false): ModeInterface;

    /**
     * @return array<int, ModeInterface>
     */
    public function getMultiple(LocationInterface $location, bool $skipCache = false): array;

    public function getOneByLocationAndId(LocationInterface $location, string $modeId, bool $skipCache = false): ModeInterface;
}
