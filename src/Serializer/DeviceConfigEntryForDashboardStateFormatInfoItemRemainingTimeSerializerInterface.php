<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;

interface DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface
{
    public const string KEY_FREQUENCY = 'frequency';
    public const string KEY_TIME_FORMAT = 'timeFormat';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface $model): array;
}
