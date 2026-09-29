<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterEndpointInterface;

interface MatterEndpointTransformerInterface
{
    public const string KEY_DEVICE_TYPES = 'deviceTypes';
    public const string KEY_ENDPOINT_ID = 'endpointId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterEndpointInterface;
}
