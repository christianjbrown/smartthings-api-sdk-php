<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PanelForDeviceConfigInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class PanelForDeviceConfigSerializer implements PanelForDeviceConfigSerializerInterface
{
    private PanelForDeviceConfigItemsItemSerializerInterface $panelForDeviceConfigItemsItemSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(PanelForDeviceConfigItemsItemSerializerInterface $panelForDeviceConfigItemsItemSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->panelForDeviceConfigItemsItemSerializer = $panelForDeviceConfigItemsItemSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(PanelForDeviceConfigInterface $model): array
    {
        $serialized = [
            self::KEY_ITEMS => $this->serializeItems($model->getItems()),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
            self::KEY_HIDE_DASHBOARD_ACTIONS => $model->getHideDashboardActions(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, PanelForDeviceConfigItemsItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeItems(array $values): array
    {
        return array_map(fn (PanelForDeviceConfigItemsItemInterface $item): array => $this->panelForDeviceConfigItemsItemSerializer->serialize($item), $values);
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
