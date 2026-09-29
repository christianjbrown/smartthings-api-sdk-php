<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;

use function array_filter;

final class DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer implements DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface $model): array
    {
        $serialized = [
            self::KEY_TIME_FORMAT => $model->getTimeFormat(),
            self::KEY_FREQUENCY => $model->getFrequency(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
