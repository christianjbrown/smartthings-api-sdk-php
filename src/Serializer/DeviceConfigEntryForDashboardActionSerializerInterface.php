<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;

interface DeviceConfigEntryForDashboardActionSerializerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_GROUP = 'group';
    public const string KEY_IDX = 'idx';
    public const string KEY_INLINE = 'inline';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardActionInterface $model): array;
}
