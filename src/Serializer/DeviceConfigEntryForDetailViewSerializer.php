<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailViewInterface;

use function array_filter;
use function array_map;

final class DeviceConfigEntryForDetailViewSerializer implements DeviceConfigEntryForDetailViewSerializerInterface
{
    private CapabilityValueSerializerInterface $capabilityValueSerializer;
    private PatchItemSerializerInterface $patchItemSerializer;
    private VisibleConditionForDetailViewSerializerInterface $visibleConditionForDetailViewSerializer;

    public function __construct(CapabilityValueSerializerInterface $capabilityValueSerializer, PatchItemSerializerInterface $patchItemSerializer, VisibleConditionForDetailViewSerializerInterface $visibleConditionForDetailViewSerializer)
    {
        $this->capabilityValueSerializer = $capabilityValueSerializer;
        $this->patchItemSerializer = $patchItemSerializer;
        $this->visibleConditionForDetailViewSerializer = $visibleConditionForDetailViewSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDetailViewInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_VALUES => $this->serializeValues($model->getValues()),
            self::KEY_PATCH => $this->serializePatch($model->getPatch()),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionForDetailViewInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionForDetailViewSerializer->serialize($value);
    }

    /**
     * @param null|array<int, PatchItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializePatch(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (PatchItemInterface $item): array => $this->patchItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, CapabilityValueInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeValues(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (CapabilityValueInterface $item): array => $this->capabilityValueSerializer->serialize($item), $values);
    }
}
