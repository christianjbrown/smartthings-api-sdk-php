<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class OrganizationSchemaApps implements OrganizationSchemaAppsInterface
{
    /**
     * @var array<int, SchemaAppInterface>
     */
    private array $endpointApps = [];

    /**
     * @var array<int, string>
     */
    private array $organizationIds = [];

    /**
     * @return array<int, SchemaAppInterface>
     */
    public function getEndpointApps(): array
    {
        return $this->endpointApps;
    }

    /**
     * @return array<int, string>
     */
    public function getOrganizationIds(): array
    {
        return $this->organizationIds;
    }

    /**
     * @param array<int, SchemaAppInterface> $value
     */
    public function setEndpointApps(array $value): OrganizationSchemaAppsInterface
    {
        $this->endpointApps = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setOrganizationIds(array $value): OrganizationSchemaAppsInterface
    {
        $this->organizationIds = $value;

        return $this;
    }
}
