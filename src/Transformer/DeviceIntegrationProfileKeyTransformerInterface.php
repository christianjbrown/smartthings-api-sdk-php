<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;

interface DeviceIntegrationProfileKeyTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_MAJOR_VERSION = 'majorVersion';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceIntegrationProfileKeyInterface;
}
