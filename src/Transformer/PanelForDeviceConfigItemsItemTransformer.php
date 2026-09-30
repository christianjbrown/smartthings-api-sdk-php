<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityValueForPanelInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItem;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class PanelForDeviceConfigItemsItemTransformer implements PanelForDeviceConfigItemsItemTransformerInterface
{
    private CapabilityValueForPanelTransformerInterface $capabilityValueForPanelTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(CapabilityValueForPanelTransformerInterface $capabilityValueForPanelTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->capabilityValueForPanelTransformer = $capabilityValueForPanelTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelForDeviceConfigItemsItemInterface
    {
        $model = new PanelForDeviceConfigItemsItem(self::requireComponent($data), self::requireCapability($data), self::requireSize($data));

        self::applyVersion($model, $data);
        self::applyIdx($model, $data);
        $this->applyValues($model, $data);
        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);
        self::applyHideOnUnmatch($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideOnUnmatch(PanelForDeviceConfigItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_HIDE_ON_UNMATCH])) {
            return;
        }
        if (!is_bool($data[self::KEY_HIDE_ON_UNMATCH])) {
            return;
        }
        $model->setHideOnUnmatch($data[self::KEY_HIDE_ON_UNMATCH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIdx(PanelForDeviceConfigItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_IDX])) {
            return;
        }
        if (!is_int($data[self::KEY_IDX])) {
            return;
        }
        $model->setIdx($data[self::KEY_IDX]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(PanelForDeviceConfigItemsItem $model, array $data): void
    {
        if (empty($data[self::KEY_OPERATOR])) {
            return;
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            return;
        }
        $model->setOperator($data[self::KEY_OPERATOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyValues(PanelForDeviceConfigItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $model->setValues($this->transformListCapabilityValueForPanel($data[self::KEY_VALUES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(PanelForDeviceConfigItemsItem $model, array $data): void
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
    private function applyVisibleConditions(PanelForDeviceConfigItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        $model->setVisibleConditions($this->transformListVisibleCondition($data[self::KEY_VISIBLE_CONDITIONS]));
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
     */
    private static function requireSize(array $data): ?string
    {
        if (empty($data[self::KEY_SIZE])) {
            return null;
        }
        if (!is_string($data[self::KEY_SIZE])) {
            return null;
        }

        return $data[self::KEY_SIZE];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityValueForPanelInterface>
     */
    private function transformListCapabilityValueForPanel(array $data): array
    {
        return array_values(array_map(fn (array $item): CapabilityValueForPanelInterface => $this->capabilityValueForPanelTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, VisibleConditionInterface>
     */
    private function transformListVisibleCondition(array $data): array
    {
        return array_values(array_map(fn (array $item): VisibleConditionInterface => $this->visibleConditionTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
