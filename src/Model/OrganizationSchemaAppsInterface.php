<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface OrganizationSchemaAppsInterface
{
    /**
     * @return array<int, SchemaAppInterface>
     */
    public function getEndpointApps(): array;

    /**
     * @return array<int, string>
     */
    public function getOrganizationIds(): array;

    /**
     * @param array<int, SchemaAppInterface> $value
     */
    public function setEndpointApps(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setOrganizationIds(array $value): self;
}
