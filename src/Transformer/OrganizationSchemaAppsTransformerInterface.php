<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OrganizationSchemaAppsInterface;

interface OrganizationSchemaAppsTransformerInterface
{
    public const string KEY_ENDPOINT_APPS = 'endpointApps';
    public const string KEY_ORGANIZATION_IDS = 'organizationIds';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrganizationSchemaAppsInterface;
}
