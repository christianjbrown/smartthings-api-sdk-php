<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardAction;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;

use function is_array;
use function is_int;
use function is_string;

final class DeviceConfigEntryForDashboardActionTransformer implements DeviceConfigEntryForDashboardActionTransformerInterface
{
    private DeviceConfigEntryForDashboardActionInlineTransformerInterface $deviceConfigEntryForDashboardActionInlineTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(DeviceConfigEntryForDashboardActionInlineTransformerInterface $deviceConfigEntryForDashboardActionInlineTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->deviceConfigEntryForDashboardActionInlineTransformer = $deviceConfigEntryForDashboardActionInlineTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardActionInterface
    {
        $model = new DeviceConfigEntryForDashboardAction(self::requireComponent($data), self::requireCapability($data));

        self::applyVersion($model, $data);
        self::applyIdx($model, $data);
        self::applyGroup($model, $data);
        $this->applyInline($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGroup(DeviceConfigEntryForDashboardAction $model, array $data): void
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
    private static function applyIdx(DeviceConfigEntryForDashboardAction $model, array $data): void
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
    private function applyInline(DeviceConfigEntryForDashboardAction $model, array $data): void
    {
        if (!isset($data[self::KEY_INLINE])) {
            return;
        }
        if (!is_array($data[self::KEY_INLINE])) {
            return;
        }
        $model->setInline($this->deviceConfigEntryForDashboardActionInlineTransformer->transform($data[self::KEY_INLINE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(DeviceConfigEntryForDashboardAction $model, array $data): void
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
    private function applyVisibleCondition(DeviceConfigEntryForDashboardAction $model, array $data): void
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
}
