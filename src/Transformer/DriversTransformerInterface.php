<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DriverInterface;

interface DriversTransformerInterface
{
    public const string ARRAY_NAME = 'driver';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DriverInterface>
     */
    public function transform(array $data): array;
}
