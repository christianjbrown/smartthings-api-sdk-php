<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardStateInterface;

use function array_filter;
use function array_map;

final class DeviceConfigEntryForDashboardStateSerializer implements DeviceConfigEntryForDashboardStateSerializerInterface
{
    private CapabilityValueForDashboardStateSerializerInterface $capabilityValueForDashboardStateSerializer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemSerializer;
    private VisibleConditionForDashboardStateSerializerInterface $visibleConditionForDashboardStateSerializer;

    public function __construct(CapabilityValueForDashboardStateSerializerInterface $capabilityValueForDashboardStateSerializer, DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemSerializer, VisibleConditionForDashboardStateSerializerInterface $visibleConditionForDashboardStateSerializer)
    {
        $this->capabilityValueForDashboardStateSerializer = $capabilityValueForDashboardStateSerializer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemSerializer = $deviceConfigEntryForDashboardStateFormatInfoItemSerializer;
        $this->visibleConditionForDashboardStateSerializer = $visibleConditionForDashboardStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardStateInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_IDX => $model->getIdx(),
            self::KEY_GROUP => $model->getGroup(),
            self::KEY_VALUES => $this->serializeValues($model->getValues()),
            self::KEY_COMPOSITE => $model->getComposite(),
            self::KEY_FORMAT_INFO => $this->serializeFormatInfo($model->getFormatInfo()),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeFormatInfo(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigEntryForDashboardStateFormatInfoItemInterface $item): array => $this->deviceConfigEntryForDashboardStateFormatInfoItemSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionForDashboardStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionForDashboardStateSerializer->serialize($value);
    }

    /**
     * @param null|array<int, CapabilityValueForDashboardStateInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeValues(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (CapabilityValueForDashboardStateInterface $item): array => $this->capabilityValueForDashboardStateSerializer->serialize($item), $values);
    }
}
