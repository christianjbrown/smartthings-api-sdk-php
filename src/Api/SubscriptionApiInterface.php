<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\SubscriptionInterface;
use ChristianBrown\SmartThings\Model\SubscriptionRequestInterface;

interface SubscriptionApiInterface extends ApiInterface
{
    public const string API_URL_LIST_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/subscriptions';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/installedapps/%s/subscriptions/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_ITEMS = 'items';
    public const string KEY_MODE_ID = 'modeId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Deletes the subscriptions of an installed app, optionally limited to one device or mode. Invalidates the cached subscriptions of that installed app.
     */
    public function deleteAllSubscriptions(string $installedAppId, ?string $deviceId = null, ?string $modeId = null): void;

    /**
     * Deletes one subscription. Invalidates its cached copy and the cached subscription list of the installed app.
     */
    public function deleteSubscription(string $installedAppId, string $subscriptionId): void;

    /**
     * @return array<int, SubscriptionInterface>
     */
    public function getMultiple(string $installedAppId, bool $skipCache = false): array;

    public function getOneById(string $installedAppId, string $subscriptionId, bool $skipCache = false): SubscriptionInterface;

    /**
     * Creates a subscription for an installed app. Invalidates the cached subscription list of that installed app.
     */
    public function saveSubscription(string $installedAppId, SubscriptionRequestInterface $request): SubscriptionInterface;
}
