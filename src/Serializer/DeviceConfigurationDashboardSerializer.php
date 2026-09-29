<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\GroupVisibleConditionsInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationDashboardSerializer implements DeviceConfigurationDashboardSerializerInterface
{
    private BasicPlusItemSerializerInterface $basicPlusItemSerializer;
    private DeviceConfigEntryForDashboardActionSerializerInterface $deviceConfigEntryForDashboardActionSerializer;
    private DeviceConfigEntryForDashboardStateSerializerInterface $deviceConfigEntryForDashboardStateSerializer;
    private GroupVisibleConditionsSerializerInterface $groupVisibleConditionsSerializer;

    public function __construct(DeviceConfigEntryForDashboardStateSerializerInterface $deviceConfigEntryForDashboardStateSerializer, DeviceConfigEntryForDashboardActionSerializerInterface $deviceConfigEntryForDashboardActionSerializer, BasicPlusItemSerializerInterface $basicPlusItemSerializer, GroupVisibleConditionsSerializerInterface $groupVisibleConditionsSerializer)
    {
        $this->deviceConfigEntryForDashboardStateSerializer = $deviceConfigEntryForDashboardStateSerializer;
        $this->deviceConfigEntryForDashboardActionSerializer = $deviceConfigEntryForDashboardActionSerializer;
        $this->basicPlusItemSerializer = $basicPlusItemSerializer;
        $this->groupVisibleConditionsSerializer = $groupVisibleConditionsSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDashboardInterface $model): array
    {
        $serialized = [
            self::KEY_STATES => $this->serializeStates($model->getStates()),
            self::KEY_ACTIONS => $this->serializeActions($model->getActions()),
            self::KEY_BASIC_PLUS => $this->serializeBasicPlus($model->getBasicPlus()),
            self::KEY_GROUP_VISIBLE_CONDITIONS => $this->serializeOptionalGroupVisibleConditions($model->getGroupVisibleConditions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardActionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeActions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigEntryForDashboardActionInterface $item): array => $this->deviceConfigEntryForDashboardActionSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, BasicPlusItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeBasicPlus(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusItemInterface $item): array => $this->basicPlusItemSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalGroupVisibleConditions(?GroupVisibleConditionsInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->groupVisibleConditionsSerializer->serialize($value);
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeStates(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigEntryForDashboardStateInterface $item): array => $this->deviceConfigEntryForDashboardStateSerializer->serialize($item), $values);
    }
}
