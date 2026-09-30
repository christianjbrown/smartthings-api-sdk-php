<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationSchemaAppsInterface;
use ChristianBrown\SmartThings\Model\UserSchemaAppsInterface;

/**
 * The apps of an organization or a user together with the wrapper fields the API
 * sends with them (the organization ids, the user id).
 */
interface SchemaAppOwnerApiInterface extends ApiInterface
{
    public const string API_URL_ORGANIZATION_APPS = 'https://api.smartthings.com/v1/schema/apps/organizations';
    public const string API_URL_USER_APPS_SPRINTF = 'https://api.smartthings.com/v1/schema/apps/user/%s';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOrganizationApps(?string $organizationId = null, bool $skipCache = false): OrganizationSchemaAppsInterface;

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getUserApps(string $userId, bool $skipCache = false): UserSchemaAppsInterface;
}
