<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;

interface DeviceConfigEntryForDetailViewSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_PATCH = 'patch';
    public const string KEY_VALUES = 'values';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDetailViewInterface $model): array;
}
