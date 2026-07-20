<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceComponentInterface;

interface DeviceComponentsTransformerInterface
{
    public const string ARRAY_NAME = 'device component';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceComponentInterface>
     */
    public function transform(array $data): array;
}
