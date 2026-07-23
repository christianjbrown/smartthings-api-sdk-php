<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OrganizationInterface;

interface OrganizationTransformerInterface
{
    public const string KEY_IS_DEFAULT_USER_ORG = 'isDefaultUserOrg';
    public const string KEY_LABEL = 'label';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_NAME = 'name';
    public const string KEY_ORGANIZATION_ID = 'organizationId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrganizationInterface;
}
