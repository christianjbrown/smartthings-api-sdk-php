<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OrganizationSchemaApps;
use ChristianBrown\SmartThings\Model\OrganizationSchemaAppsInterface;

final class OrganizationSchemaAppsTransformer implements OrganizationSchemaAppsTransformerInterface
{
    private SchemaAppsTransformerInterface $schemaAppsTransformer;
    private ValueReaderInterface $valueReader;

    public function __construct(SchemaAppsTransformerInterface $schemaAppsTransformer, ValueReaderInterface $valueReader)
    {
        $this->schemaAppsTransformer = $schemaAppsTransformer;
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrganizationSchemaAppsInterface
    {
        return (new OrganizationSchemaApps())
            ->setOrganizationIds($this->valueReader->strings($data, self::KEY_ORGANIZATION_IDS))
            ->setEndpointApps($this->schemaAppsTransformer->transform($this->valueReader->records($data, self::KEY_ENDPOINT_APPS)));
    }
}
