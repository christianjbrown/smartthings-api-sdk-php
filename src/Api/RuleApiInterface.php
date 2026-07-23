<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\RuleInterface;

interface RuleApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/rules';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/rules/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string MISSING_LOCATION_ID = 'Location id is required';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, RuleInterface>
     */
    public function getMultiple(string $locationId, bool $skipCache = false): array;

    public function getOneById(string $ruleId, string $locationId, bool $skipCache = false): RuleInterface;
}
