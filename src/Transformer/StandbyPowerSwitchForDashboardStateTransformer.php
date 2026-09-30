<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardState;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class StandbyPowerSwitchForDashboardStateTransformer implements StandbyPowerSwitchForDashboardStateTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StandbyPowerSwitchForDashboardStateInterface
    {
        $model = new StandbyPowerSwitchForDashboardState(self::requireValue($data), self::requireOn($data), self::requireOff($data));

        self::applyValueType($model, $data);
        self::applyLabel($model, $data);
        $this->applyAlternatives($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(StandbyPowerSwitchForDashboardState $model, array $data): void
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
    private static function applyLabel(StandbyPowerSwitchForDashboardState $model, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $model->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(StandbyPowerSwitchForDashboardState $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOff(array $data): ?string
    {
        if (empty($data[self::KEY_OFF])) {
            return null;
        }
        if (!is_string($data[self::KEY_OFF])) {
            return null;
        }

        return $data[self::KEY_OFF];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOn(array $data): ?string
    {
        if (empty($data[self::KEY_ON])) {
            return null;
        }
        if (!is_string($data[self::KEY_ON])) {
            return null;
        }

        return $data[self::KEY_ON];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): ?string
    {
        if (empty($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return null;
        }

        return $data[self::KEY_VALUE];
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
}
