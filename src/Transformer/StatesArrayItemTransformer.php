<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\StatesArrayItem;
use ChristianBrown\SmartThings\Model\StatesArrayItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class StatesArrayItemTransformer implements StatesArrayItemTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTransformer;
    private VisibleConditionForDashboardStateTransformerInterface $visibleConditionForDashboardStateTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer, VisibleConditionForDashboardStateTransformerInterface $visibleConditionForDashboardStateTransformer, DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
        $this->visibleConditionForDashboardStateTransformer = $visibleConditionForDashboardStateTransformer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemTransformer = $deviceConfigEntryForDashboardStateFormatInfoItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StatesArrayItemInterface
    {
        $model = new StatesArrayItem(self::requireLabel($data), self::requireCapability($data), self::requireComponent($data));

        $this->applyAlternatives($model, $data);
        self::applyVersion($model, $data);
        $this->applyVisibleCondition($model, $data);
        self::applyComposite($model, $data);
        self::applyGroup($model, $data);
        $this->applyFormatInfo($model, $data);
        self::applyTransient($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(StatesArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        if (!is_array($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        $model->setAlternatives($this->transformListAlternativeItem($data[self::KEY_ALTERNATIVES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComposite(StatesArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_COMPOSITE])) {
            return;
        }
        if (!is_bool($data[self::KEY_COMPOSITE])) {
            return;
        }
        $model->setComposite($data[self::KEY_COMPOSITE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFormatInfo(StatesArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_FORMAT_INFO])) {
            return;
        }
        if (!is_array($data[self::KEY_FORMAT_INFO])) {
            return;
        }
        $model->setFormatInfo($this->transformListDeviceConfigEntryForDashboardStateFormatInfoItem($data[self::KEY_FORMAT_INFO]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroup(StatesArrayItem $model, array $data): void
    {
        if (empty($data[self::KEY_GROUP])) {
            return;
        }
        if (!is_string($data[self::KEY_GROUP])) {
            return;
        }
        $model->setGroup($data[self::KEY_GROUP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTransient(StatesArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TRANSIENT])) {
            return;
        }
        if (!is_bool($data[self::KEY_TRANSIENT])) {
            return;
        }
        $model->setTransient($data[self::KEY_TRANSIENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(StatesArrayItem $model, array $data): void
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
    private function applyVisibleCondition(StatesArrayItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionForDashboardStateTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
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
    private static function requireLabel(array $data): ?string
    {
        if (empty($data[self::KEY_LABEL])) {
            return null;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return null;
        }

        return $data[self::KEY_LABEL];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    private function transformListDeviceConfigEntryForDashboardStateFormatInfoItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigEntryForDashboardStateFormatInfoItemInterface => $this->deviceConfigEntryForDashboardStateFormatInfoItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
