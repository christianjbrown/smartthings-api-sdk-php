<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationSerializer implements DeviceConfigurationSerializerInterface
{
    private DeviceConfigEntryForDetailViewSerializerInterface $deviceConfigEntryForDetailViewSerializer;
    private DeviceConfigurationAutomationSerializerInterface $deviceConfigurationAutomationSerializer;
    private DeviceConfigurationDashboardSerializerInterface $deviceConfigurationDashboardSerializer;
    private DeviceConfigurationDpInfoItemSerializerInterface $deviceConfigurationDpInfoItemSerializer;
    private DeviceConfigurationDpInfosItemSerializerInterface $deviceConfigurationDpInfosItemSerializer;
    private DeviceConfigurationIconsItemSerializerInterface $deviceConfigurationIconsItemSerializer;

    public function __construct(DeviceConfigurationDpInfoItemSerializerInterface $deviceConfigurationDpInfoItemSerializer, DeviceConfigurationDpInfosItemSerializerInterface $deviceConfigurationDpInfosItemSerializer, DeviceConfigurationIconsItemSerializerInterface $deviceConfigurationIconsItemSerializer, DeviceConfigurationDashboardSerializerInterface $deviceConfigurationDashboardSerializer, DeviceConfigEntryForDetailViewSerializerInterface $deviceConfigEntryForDetailViewSerializer, DeviceConfigurationAutomationSerializerInterface $deviceConfigurationAutomationSerializer)
    {
        $this->deviceConfigurationDpInfoItemSerializer = $deviceConfigurationDpInfoItemSerializer;
        $this->deviceConfigurationDpInfosItemSerializer = $deviceConfigurationDpInfosItemSerializer;
        $this->deviceConfigurationIconsItemSerializer = $deviceConfigurationIconsItemSerializer;
        $this->deviceConfigurationDashboardSerializer = $deviceConfigurationDashboardSerializer;
        $this->deviceConfigEntryForDetailViewSerializer = $deviceConfigEntryForDetailViewSerializer;
        $this->deviceConfigurationAutomationSerializer = $deviceConfigurationAutomationSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationInterface $model): array
    {
        $serialized = [
            self::KEY_MNMN => $model->getMnmn(),
            self::KEY_VID => $model->getVid(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_DESCRIPTION => $model->getDescription(),
            self::KEY_TYPE => $model->getType(),
            self::KEY_DP_INFO => $this->serializeDpInfo($model->getDpInfo()),
            self::KEY_DP_INFOS => $this->serializeDpInfos($model->getDpInfos()),
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_ICONS => $this->serializeIcons($model->getIcons()),
            self::KEY_DASHBOARD => $this->serializeOptionalDashboard($model->getDashboard()),
            self::KEY_DETAIL_VIEW => $this->serializeDetailView($model->getDetailView()),
            self::KEY_AUTOMATION => $this->serializeOptionalAutomation($model->getAutomation()),
            self::KEY_PRESENTATION_ID => $model->getPresentationId(),
            self::KEY_MANUFACTURER_NAME => $model->getManufacturerName(),
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
     * @param null|array<int, DeviceConfigurationDpInfoItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeDpInfo(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigurationDpInfoItemInterface $item): array => $this->deviceConfigurationDpInfoItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfosItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeDpInfos(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigurationDpInfosItemInterface $item): array => $this->deviceConfigurationDpInfosItemSerializer->serialize($item), $values);
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
    private function serializeOptionalAutomation(?DeviceConfigurationAutomationInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->deviceConfigurationAutomationSerializer->serialize($value);
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
