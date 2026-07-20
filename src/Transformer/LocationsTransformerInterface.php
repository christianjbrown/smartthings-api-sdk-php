<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationInterface;

interface LocationsTransformerInterface
{
    public const string ARRAY_NAME = 'location';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, LocationInterface>
     */
    public function transform(array $data): array;
}
