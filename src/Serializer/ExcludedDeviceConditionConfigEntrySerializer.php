<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\PatchItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class ExcludedDeviceConditionConfigEntrySerializer implements ExcludedDeviceConditionConfigEntrySerializerInterface
{
    private CapabilityValueSerializerInterface $capabilityValueSerializer;
    private ExcludedConditionItemIdSerializerInterface $excludedConditionItemIdSerializer;
    private PatchItemSerializerInterface $patchItemSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(CapabilityValueSerializerInterface $capabilityValueSerializer, PatchItemSerializerInterface $patchItemSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer, ExcludedConditionItemIdSerializerInterface $excludedConditionItemIdSerializer)
    {
        $this->capabilityValueSerializer = $capabilityValueSerializer;
        $this->patchItemSerializer = $patchItemSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
        $this->excludedConditionItemIdSerializer = $excludedConditionItemIdSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedDeviceConditionConfigEntryInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_VALUES => $this->serializeValues($model->getValues()),
            self::KEY_PATCH => $this->serializePatch($model->getPatch()),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
            self::KEY_EXCLUSION => $this->serializeExclusion($model->getExclusion()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, ExcludedConditionItemIdInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeExclusion(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (ExcludedConditionItemIdInterface $item): array => $this->excludedConditionItemIdSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionSerializer->serialize($value);
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
