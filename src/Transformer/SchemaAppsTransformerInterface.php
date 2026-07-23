<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInterface;

interface SchemaAppsTransformerInterface
{
    public const string ARRAY_NAME = 'schemaApp';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, SchemaAppInterface>
     */
    public function transform(array $data): array;
}
