<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterEndpointDeviceTypeInterface;

interface MatterEndpointDeviceTypeTransformerInterface
{
    public const string KEY_DEVICE_TYPE_ID = 'deviceTypeId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterEndpointDeviceTypeInterface;
}
