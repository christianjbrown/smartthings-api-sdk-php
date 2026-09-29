<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\VirtualDeviceDetailsInterface;

interface VirtualDeviceDetailsTransformerInterface
{
    public const string KEY_COMMAND_MAPPINGS = 'commandMappings';
    public const string KEY_DRIVER_ID = 'driverId';
    public const string KEY_EXECUTING_LOCALLY = 'executingLocally';
    public const string KEY_HUB_ID = 'hubId';
    public const string KEY_NAME = 'name';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VirtualDeviceDetailsInterface;
}
