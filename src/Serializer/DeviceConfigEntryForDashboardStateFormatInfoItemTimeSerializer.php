<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;

final class DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer implements DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface $model): array
    {
        return [
            self::KEY_TIME_FORMAT => $model->getTimeFormat(),
        ];
    }
}
