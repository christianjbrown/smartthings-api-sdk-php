<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;

use function is_int;
use function is_string;

final class DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformer implements DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface
    {
        $model = new DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime(self::requireTimeFormat($data));

        self::applyFrequency($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFrequency(DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime $model, array $data): void
    {
        if (!isset($data[self::KEY_FREQUENCY])) {
            return;
        }
        if (!is_int($data[self::KEY_FREQUENCY])) {
            return;
        }
        $model->setFrequency($data[self::KEY_FREQUENCY]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTimeFormat(array $data): ?string
    {
        if (empty($data[self::KEY_TIME_FORMAT])) {
            return null;
        }
        if (!is_string($data[self::KEY_TIME_FORMAT])) {
            return null;
        }

        return $data[self::KEY_TIME_FORMAT];
    }
}
