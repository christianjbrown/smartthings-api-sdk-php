<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ActionItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;
use ChristianBrown\SmartThings\Model\StateItemInterface;

use function array_filter;
use function array_map;

final class DashboardForCapabilitySerializer implements DashboardForCapabilitySerializerInterface
{
    private ActionItemSerializerInterface $actionItemSerializer;
    private PanelItemForCapabilitySerializerInterface $panelItemForCapabilitySerializer;
    private StateItemSerializerInterface $stateItemSerializer;

    public function __construct(StateItemSerializerInterface $stateItemSerializer, ActionItemSerializerInterface $actionItemSerializer, PanelItemForCapabilitySerializerInterface $panelItemForCapabilitySerializer)
    {
        $this->stateItemSerializer = $stateItemSerializer;
        $this->actionItemSerializer = $actionItemSerializer;
        $this->panelItemForCapabilitySerializer = $panelItemForCapabilitySerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DashboardForCapabilityInterface $model): array
    {
        $serialized = [
            self::KEY_STATES => $this->serializeStates($model->getStates()),
            self::KEY_ACTIONS => $this->serializeActions($model->getActions()),
            self::KEY_PANEL_ITEMS => $this->serializePanelItems($model->getPanelItems()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, ActionItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeActions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (ActionItemInterface $item): array => $this->actionItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, PanelItemForCapabilityInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializePanelItems(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (PanelItemForCapabilityInterface $item): array => $this->panelItemForCapabilitySerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, StateItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeStates(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (StateItemInterface $item): array => $this->stateItemSerializer->serialize($item), $values);
    }
}
