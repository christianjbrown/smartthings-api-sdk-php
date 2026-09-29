<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardState;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function sprintf;

final class DeviceConfigEntryForDashboardStateTransformer implements DeviceConfigEntryForDashboardStateTransformerInterface
{
    private CapabilityValueForDashboardStateTransformerInterface $capabilityValueForDashboardStateTransformer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTransformer;
    private VisibleConditionForDashboardStateTransformerInterface $visibleConditionForDashboardStateTransformer;

    public function __construct(CapabilityValueForDashboardStateTransformerInterface $capabilityValueForDashboardStateTransformer, DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTransformer, VisibleConditionForDashboardStateTransformerInterface $visibleConditionForDashboardStateTransformer)
    {
        $this->capabilityValueForDashboardStateTransformer = $capabilityValueForDashboardStateTransformer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemTransformer = $deviceConfigEntryForDashboardStateFormatInfoItemTransformer;
        $this->visibleConditionForDashboardStateTransformer = $visibleConditionForDashboardStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardStateInterface
    {
        $model = new DeviceConfigEntryForDashboardState(self::requireComponent($data), self::requireCapability($data));

        self::applyVersion($model, $data);
        self::applyIdx($model, $data);
        self::applyGroup($model, $data);
        $this->applyValues($model, $data);
        self::applyComposite($model, $data);
        $this->applyFormatInfo($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComposite(DeviceConfigEntryForDashboardState $model, array $data): void
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
    private function applyFormatInfo(DeviceConfigEntryForDashboardState $model, array $data): void
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
    private static function applyGroup(DeviceConfigEntryForDashboardState $model, array $data): void
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
    private static function applyIdx(DeviceConfigEntryForDashboardState $model, array $data): void
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
    private function applyValues(DeviceConfigEntryForDashboardState $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $model->setValues($this->transformListCapabilityValueForDashboardState($data[self::KEY_VALUES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(DeviceConfigEntryForDashboardState $model, array $data): void
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
    private function applyVisibleCondition(DeviceConfigEntryForDashboardState $model, array $data): void
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
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityValueForDashboardStateInterface>
     */
    private function transformListCapabilityValueForDashboardState(array $data): array
    {
        return array_values(array_map(fn (array $item): CapabilityValueForDashboardStateInterface => $this->capabilityValueForDashboardStateTransformer->transform($item), array_filter($data, is_array(...))));
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
