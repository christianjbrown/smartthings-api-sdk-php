<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CronSchedule;
use ChristianBrown\SmartThings\Model\CronScheduleInterface;

use function is_string;

final class CronScheduleTransformer implements CronScheduleTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CronScheduleInterface
    {
        $model = new CronSchedule(self::requireExpression($data), self::requireTimezone($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireExpression(array $data): ?string
    {
        if (empty($data[self::KEY_EXPRESSION])) {
            return null;
        }
        if (!is_string($data[self::KEY_EXPRESSION])) {
            return null;
        }

        return $data[self::KEY_EXPRESSION];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTimezone(array $data): ?string
    {
        if (empty($data[self::KEY_TIMEZONE])) {
            return null;
        }
        if (!is_string($data[self::KEY_TIMEZONE])) {
            return null;
        }

        return $data[self::KEY_TIMEZONE];
    }
}
