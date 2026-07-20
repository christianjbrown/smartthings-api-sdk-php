<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceComponentCapabilityInterface;

interface DeviceComponentCapabilitiesTransformerInterface
{
    public const string ARRAY_NAME = 'device component capability';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceComponentCapabilityInterface>
     */
    public function transform(array $data): array;
}
