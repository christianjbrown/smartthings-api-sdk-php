<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\OrganizationInterface;

interface OrganizationApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/organizations';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/organizations/%s';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, OrganizationInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $organizationId, bool $skipCache = false): OrganizationInterface;
}
