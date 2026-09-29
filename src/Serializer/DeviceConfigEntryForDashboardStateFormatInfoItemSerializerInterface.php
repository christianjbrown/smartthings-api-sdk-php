<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;

interface DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface
{
    public const string KEY_KEY = 'key';
    public const string KEY_REMAINING_TIME = 'remainingTime';
    public const string KEY_TIME = 'time';
    public const string KEY_TYPE = 'type';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateFormatInfoItemInterface $model): array;
}
