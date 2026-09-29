<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueForPanelInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class PanelForDeviceConfigItemsItemSerializer implements PanelForDeviceConfigItemsItemSerializerInterface
{
    private CapabilityValueForPanelSerializerInterface $capabilityValueForPanelSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(CapabilityValueForPanelSerializerInterface $capabilityValueForPanelSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->capabilityValueForPanelSerializer = $capabilityValueForPanelSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(PanelForDeviceConfigItemsItemInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_IDX => $model->getIdx(),
            self::KEY_SIZE => $model->getSize(),
            self::KEY_VALUES => $this->serializeValues($model->getValues()),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
            self::KEY_HIDE_ON_UNMATCH => $model->getHideOnUnmatch(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, CapabilityValueForPanelInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeValues(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (CapabilityValueForPanelInterface $item): array => $this->capabilityValueForPanelSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeVisibleConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (VisibleConditionInterface $item): array => $this->visibleConditionSerializer->serialize($item), $values);
    }
}
