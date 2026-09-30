<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntry;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\PatchItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

final class ExcludedDeviceActionConfigEntryTransformer implements ExcludedDeviceActionConfigEntryTransformerInterface
{
    private CapabilityValueTransformerInterface $capabilityValueTransformer;
    private ExcludedActionItemIdTransformerInterface $excludedActionItemIdTransformer;
    private PatchItemTransformerInterface $patchItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(CapabilityValueTransformerInterface $capabilityValueTransformer, PatchItemTransformerInterface $patchItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer, ExcludedActionItemIdTransformerInterface $excludedActionItemIdTransformer)
    {
        $this->capabilityValueTransformer = $capabilityValueTransformer;
        $this->patchItemTransformer = $patchItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
        $this->excludedActionItemIdTransformer = $excludedActionItemIdTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedDeviceActionConfigEntryInterface
    {
        $model = new ExcludedDeviceActionConfigEntry(self::requireComponent($data), self::requireCapability($data));

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
    private function applyExclusion(ExcludedDeviceActionConfigEntry $model, array $data): void
    {
        if (!isset($data[self::KEY_EXCLUSION])) {
            return;
        }
        if (!is_array($data[self::KEY_EXCLUSION])) {
            return;
        }
        $model->setExclusion($this->transformListExcludedActionItemId($data[self::KEY_EXCLUSION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPatch(ExcludedDeviceActionConfigEntry $model, array $data): void
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
    private function applyValues(ExcludedDeviceActionConfigEntry $model, array $data): void
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
    private static function applyVersion(ExcludedDeviceActionConfigEntry $model, array $data): void
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
    private function applyVisibleCondition(ExcludedDeviceActionConfigEntry $model, array $data): void
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
     * @return array<int, ExcludedActionItemIdInterface>
     */
    private function transformListExcludedActionItemId(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedActionItemIdInterface => $this->excludedActionItemIdTransformer->transform($item), array_filter($data, is_array(...))));
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
