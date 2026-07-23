<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\SubscriptionInterface;

interface SubscriptionApiInterface extends ApiInterface
{
    public const string API_URL_LIST_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/subscriptions';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/subscriptions/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, SubscriptionInterface>
     */
    public function getMultiple(string $installedAppId, bool $skipCache = false): array;

    public function getOneById(string $installedAppId, string $subscriptionId, bool $skipCache = false): SubscriptionInterface;
}
