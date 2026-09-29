<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;

use function array_filter;
use function array_map;

final class AutomationForCapabilitySerializer implements AutomationForCapabilitySerializerInterface
{
    private AutomationForCapabilityActionsItemSerializerInterface $automationForCapabilityActionsItemSerializer;
    private AutomationForCapabilityConditionsItemSerializerInterface $automationForCapabilityConditionsItemSerializer;

    public function __construct(AutomationForCapabilityConditionsItemSerializerInterface $automationForCapabilityConditionsItemSerializer, AutomationForCapabilityActionsItemSerializerInterface $automationForCapabilityActionsItemSerializer)
    {
        $this->automationForCapabilityConditionsItemSerializer = $automationForCapabilityConditionsItemSerializer;
        $this->automationForCapabilityActionsItemSerializer = $automationForCapabilityActionsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(AutomationForCapabilityInterface $model): array
    {
        $serialized = [
            self::KEY_CONDITIONS => $this->serializeConditions($model->getConditions()),
            self::KEY_ACTIONS => $this->serializeActions($model->getActions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, AutomationForCapabilityActionsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeActions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (AutomationForCapabilityActionsItemInterface $item): array => $this->automationForCapabilityActionsItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, AutomationForCapabilityConditionsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (AutomationForCapabilityConditionsItemInterface $item): array => $this->automationForCapabilityConditionsItemSerializer->serialize($item), $values);
    }
}
