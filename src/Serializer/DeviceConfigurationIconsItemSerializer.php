<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationIconsItemSerializer implements DeviceConfigurationIconsItemSerializerInterface
{
    private DeviceConfigurationIconsItemBadgeItemSerializerInterface $deviceConfigurationIconsItemBadgeItemSerializer;
    private DeviceConfigurationIconsItemProductKeysItemSerializerInterface $deviceConfigurationIconsItemProductKeysItemSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(VisibleConditionSerializerInterface $visibleConditionSerializer, DeviceConfigurationIconsItemBadgeItemSerializerInterface $deviceConfigurationIconsItemBadgeItemSerializer, DeviceConfigurationIconsItemProductKeysItemSerializerInterface $deviceConfigurationIconsItemProductKeysItemSerializer)
    {
        $this->visibleConditionSerializer = $visibleConditionSerializer;
        $this->deviceConfigurationIconsItemBadgeItemSerializer = $deviceConfigurationIconsItemBadgeItemSerializer;
        $this->deviceConfigurationIconsItemProductKeysItemSerializer = $deviceConfigurationIconsItemProductKeysItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationIconsItemInterface $model): array
    {
        $serialized = [
            self::KEY_GROUP => $model->getGroup(),
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_RUNNING_CONDITIONS => $this->serializeRunningConditions($model->getRunningConditions()),
            self::KEY_BADGE => $this->serializeBadge($model->getBadge()),
            self::KEY_PRODUCT_KEYS => $this->serializeProductKeys($model->getProductKeys()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemBadgeItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeBadge(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigurationIconsItemBadgeItemInterface $item): array => $this->deviceConfigurationIconsItemBadgeItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemProductKeysItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeProductKeys(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigurationIconsItemProductKeysItemInterface $item): array => $this->deviceConfigurationIconsItemProductKeysItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeRunningConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (VisibleConditionInterface $item): array => $this->visibleConditionSerializer->serialize($item), $values);
    }
}
