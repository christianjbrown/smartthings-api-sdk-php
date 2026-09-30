<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\UserSchemaApps;
use ChristianBrown\SmartThings\Model\UserSchemaAppsInterface;

final class UserSchemaAppsTransformer implements UserSchemaAppsTransformerInterface
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
    public function transform(array $data): UserSchemaAppsInterface
    {
        return (new UserSchemaApps())
            ->setUserId($this->valueReader->string($data, self::KEY_USER_ID))
            ->setEndpointApps($this->schemaAppsTransformer->transform($this->valueReader->records($data, self::KEY_ENDPOINT_APPS)));
    }
}
