<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;

interface DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface
{
    public const string KEY_TIME_FORMAT = 'timeFormat';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface $model): array;
}
