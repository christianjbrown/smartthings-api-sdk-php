<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GroupDeviceDetailsInterface;

interface GroupDeviceDetailsTransformerInterface
{
    public const string KEY_DEVICES = 'devices';
    public const string KEY_GROUP_NAME = 'groupName';
    public const string KEY_GROUP_TYPE = 'groupType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GroupDeviceDetailsInterface;
}
