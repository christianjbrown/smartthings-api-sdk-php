<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;

use function array_filter;

final class DeviceConfigEntryForDashboardStateFormatInfoItemSerializer implements DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface
{
    private DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer;

    public function __construct(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer, DeviceConfigEntryForDashboardStateFormatInfoItemTimeSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer)
    {
        $this->deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer = $deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer = $deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateFormatInfoItemInterface $model): array
    {
        $serialized = [
            self::KEY_KEY => $model->getKey(),
            self::KEY_TYPE => $model->getType(),
            self::KEY_REMAINING_TIME => $this->serializeOptionalRemainingTime($model->getRemainingTime()),
            self::KEY_TIME => $this->serializeOptionalTime($model->getTime()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalRemainingTime(?DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->deviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTime(?DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->deviceConfigEntryForDashboardStateFormatInfoItemTimeSerializer->serialize($value);
    }
}
