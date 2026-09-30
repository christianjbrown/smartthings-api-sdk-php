<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;
use ChristianBrown\SmartThings\Model\ServiceSubscriptionReceiptInterface;
use ChristianBrown\SmartThings\Model\ServiceSubscriptionRequestInterface;

interface ServiceApiInterface extends ApiInterface
{
    public const string API_URL_ALERT_LINK_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s/link/alert';
    public const string API_URL_CAPABILITIES_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s/capabilities';
    public const string API_URL_INFO_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s';
    public const string API_URL_SUBSCRIPTION_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s/subscriptions/%s';
    public const string API_URL_SUBSCRIPTIONS_SPRINTF = 'https://api.smartthings.com/v1/services/coordinate/locations/%s/subscriptions';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string HEADER_KEY_UNITS = 'X-ST-Units';
    public const string KEY_ISA_ID = 'isaId';
    public const string KEY_LOCATION = RedirectLocationResponseMapperInterface::KEY_LOCATION;
    public const string KEY_NAME = 'name';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_SUBSCRIPTION_ID = 'subscriptionId';
    public const string UNEXPECTED_LOCATION = 'Alert link location not set or not a string';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Creates a location service subscription. Invalidates the cached service info of the location.
     */
    public function createSubscription(string $locationId, ServiceSubscriptionRequestInterface $request): ServiceSubscriptionReceiptInterface;

    /**
     * Deletes a location service subscription. Invalidates the cached service info of the location.
     */
    public function deleteSubscription(string $locationId, string $subscriptionId): void;

    /**
     * Deletes the location service subscriptions of an installed schema app. Invalidates the cached service info of the location.
     */
    public function deleteSubscriptionsByInstalledApp(string $locationId, string $isaId): void;

    /**
     * Returns the address the service redirects to for the location's weather alert
     * detail page, without following the redirect.
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getAlertLink(string $locationId, ?string $postalCode = null, ?string $subscriptionId = null, ?string $units = null, ?string $acceptLanguage = null): string;

    /**
     * @return array<int, string>
     */
    public function getAvailableCapabilities(string $locationId, bool $skipCache = false, ?string $postalCode = null): array;

    public function getCapability(string $locationId, string $name, bool $skipCache = false, ?string $postalCode = null): ServiceCapabilityDataInterface;

    public function getLocationInfo(string $locationId, bool $skipCache = false): ServiceLocationInfoInterface;

    /**
     * Replaces a location service subscription. Invalidates the cached service info of the location.
     */
    public function updateSubscription(string $locationId, string $subscriptionId, ServiceSubscriptionRequestInterface $request): void;
}
