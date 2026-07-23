<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

interface DeviceProfilesTransformerInterface
{
    public const string ARRAY_NAME = 'device profile';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceProfileInterface>
     */
    public function transform(array $data): array;
}
