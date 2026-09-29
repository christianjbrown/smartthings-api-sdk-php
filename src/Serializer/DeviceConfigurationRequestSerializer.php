<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationRequestSerializer implements DeviceConfigurationRequestSerializerInterface
{
    private DeviceConfigEntryForDetailViewSerializerInterface $deviceConfigEntryForDetailViewSerializer;
    private DeviceConfigurationDashboardSerializerInterface $deviceConfigurationDashboardSerializer;
    private DeviceConfigurationIconsItemSerializerInterface $deviceConfigurationIconsItemSerializer;
    private DeviceConfigurationRequestAutomationSerializerInterface $deviceConfigurationRequestAutomationSerializer;

    public function __construct(DeviceConfigurationIconsItemSerializerInterface $deviceConfigurationIconsItemSerializer, DeviceConfigurationDashboardSerializerInterface $deviceConfigurationDashboardSerializer, DeviceConfigEntryForDetailViewSerializerInterface $deviceConfigEntryForDetailViewSerializer, DeviceConfigurationRequestAutomationSerializerInterface $deviceConfigurationRequestAutomationSerializer)
    {
        $this->deviceConfigurationIconsItemSerializer = $deviceConfigurationIconsItemSerializer;
        $this->deviceConfigurationDashboardSerializer = $deviceConfigurationDashboardSerializer;
        $this->deviceConfigEntryForDetailViewSerializer = $deviceConfigEntryForDetailViewSerializer;
        $this->deviceConfigurationRequestAutomationSerializer = $deviceConfigurationRequestAutomationSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationRequestInterface $model): array
    {
        $serialized = [
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_ICONS => $this->serializeIcons($model->getIcons()),
            self::KEY_DASHBOARD => $this->serializeOptionalDashboard($model->getDashboard()),
            self::KEY_DETAIL_VIEW => $this->serializeDetailView($model->getDetailView()),
            self::KEY_AUTOMATION => $this->serializeOptionalAutomation($model->getAutomation()),
            self::KEY_TYPE => $model->getType(),
            self::KEY_DEVICE_PROFILE_ID => $model->getDeviceProfileId(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDetailViewInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeDetailView(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigEntryForDetailViewInterface $item): array => $this->deviceConfigEntryForDetailViewSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeIcons(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigurationIconsItemInterface $item): array => $this->deviceConfigurationIconsItemSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalAutomation(?DeviceConfigurationRequestAutomationInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->deviceConfigurationRequestAutomationSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalDashboard(?DeviceConfigurationDashboardInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->deviceConfigurationDashboardSerializer->serialize($value);
    }
}
