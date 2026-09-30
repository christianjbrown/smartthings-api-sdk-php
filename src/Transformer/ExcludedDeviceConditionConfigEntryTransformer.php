<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntry;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\PatchItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

final class ExcludedDeviceConditionConfigEntryTransformer implements ExcludedDeviceConditionConfigEntryTransformerInterface
{
    private CapabilityValueTransformerInterface $capabilityValueTransformer;
    private ExcludedConditionItemIdTransformerInterface $excludedConditionItemIdTransformer;
    private PatchItemTransformerInterface $patchItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(CapabilityValueTransformerInterface $capabilityValueTransformer, PatchItemTransformerInterface $patchItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer, ExcludedConditionItemIdTransformerInterface $excludedConditionItemIdTransformer)
    {
        $this->capabilityValueTransformer = $capabilityValueTransformer;
        $this->patchItemTransformer = $patchItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
        $this->excludedConditionItemIdTransformer = $excludedConditionItemIdTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedDeviceConditionConfigEntryInterface
    {
        $model = new ExcludedDeviceConditionConfigEntry(self::requireComponent($data), self::requireCapability($data));

        self::applyVersion($model, $data);
        $this->applyValues($model, $data);
        $this->applyPatch($model, $data);
        $this->applyVisibleCondition($model, $data);
        $this->applyExclusion($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyExclusion(ExcludedDeviceConditionConfigEntry $model, array $data): void
    {
        if (!isset($data[self::KEY_EXCLUSION])) {
            return;
        }
        if (!is_array($data[self::KEY_EXCLUSION])) {
            return;
        }
        $model->setExclusion($this->transformListExcludedConditionItemId($data[self::KEY_EXCLUSION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPatch(ExcludedDeviceConditionConfigEntry $model, array $data): void
    {
        if (!isset($data[self::KEY_PATCH])) {
            return;
        }
        if (!is_array($data[self::KEY_PATCH])) {
            return;
        }
        $model->setPatch($this->transformListPatchItem($data[self::KEY_PATCH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyValues(ExcludedDeviceConditionConfigEntry $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $model->setValues($this->transformListCapabilityValue($data[self::KEY_VALUES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(ExcludedDeviceConditionConfigEntry $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleCondition(ExcludedDeviceConditionConfigEntry $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityValueInterface>
     */
    private function transformListCapabilityValue(array $data): array
    {
        return array_values(array_map(fn (array $item): CapabilityValueInterface => $this->capabilityValueTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedConditionItemIdInterface>
     */
    private function transformListExcludedConditionItemId(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedConditionItemIdInterface => $this->excludedConditionItemIdTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PatchItemInterface>
     */
    private function transformListPatchItem(array $data): array
    {
        return array_values(array_map(fn (array $item): PatchItemInterface => $this->patchItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
