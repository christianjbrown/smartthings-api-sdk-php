<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileReferenceInterface;

interface DeviceProfileReferenceTransformerInterface
{
    public const string KEY_ID = 'id';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileReferenceInterface;
}
