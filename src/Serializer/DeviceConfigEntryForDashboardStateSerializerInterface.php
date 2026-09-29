<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;

interface DeviceConfigEntryForDashboardStateSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_COMPOSITE = 'composite';
    public const string KEY_FORMAT_INFO = 'formatInfo';
    public const string KEY_GROUP = 'group';
    public const string KEY_IDX = 'idx';
    public const string KEY_VALUES = 'values';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateInterface $model): array;
}
