<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;

interface InstalledSchemaAppsTransformerInterface
{
    public const string ARRAY_NAME = 'installedSchemaApp';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstalledSchemaAppInterface>
     */
    public function transform(array $data): array;
}
